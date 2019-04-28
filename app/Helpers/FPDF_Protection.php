<?php

/****************************************************************************
 * Software: FPDF_Protection                                                 *
 * Version:  1.05                                                            *
 * Date:     2018-03-19                                                      *
 * Author:   Klemen VODOPIVEC                                                *
 * License:  FPDF                                                            *
 *                                                                           *
 * Thanks:  Cpdf (http://www.ros.co.nz/pdf) was my working sample of how to  *
 *          implement protection in pdf.                                     *
 ****************************************************************************/

namespace App\Helpers;

use Crabbly\FPDF\FPDF as FPDF;

if (function_exists('openssl_encrypt')) {
    function RC4($key, $data)
    {
        return openssl_encrypt($data, 'RC4-40', $key, OPENSSL_RAW_DATA);
    }
} elseif (function_exists('mcrypt_encrypt')) {
    function RC4($key, $data)
    {
        return @mcrypt_encrypt(MCRYPT_ARCFOUR, $key, $data, MCRYPT_MODE_STREAM, '');
    }
} else {
    function RC4($key, $data)
    {
        static $last_key, $last_state;

        if ($key != $last_key) {
            $k = str_repeat($key, 256 / strlen($key) + 1);
            $state = range(0, 255);
            $j = 0;
            for ($i = 0; $i < 256; $i++) {
                $t = $state[$i];
                $j = ($j + $t + ord($k[$i])) % 256;
                $state[$i] = $state[$j];
                $state[$j] = $t;
            }
            $last_key = $key;
            $last_state = $state;
        } else {
            $state = $last_state;
        }

        $len = strlen($data);
        $a = 0;
        $b = 0;
        $out = '';
        for ($i = 0; $i < $len; $i++) {
            $a = ($a + 1) % 256;
            $t = $state[$a];
            $b = ($b + $t) % 256;
            $state[$a] = $state[$b];
            $state[$b] = $t;
            $k = $state[($state[$a] + $state[$b]) % 256];
            $out .= chr(ord($data[$i]) ^ $k);
        }
        return $out;
    }
}

class FPDF_Protection extends FPDF
{
    protected $encrypted = false; //whether document is protected
    protected $Uvalue; //U entry in pdf document
    protected $Ovalue; //O entry in pdf document
    protected $Pvalue; //P entry in pdf document
    protected $enc_obj_id; //encryption object id

    /**
     * Function to set permissions as well as user and owner passwords
     *
     * - permissions is an array with values taken from the following list:
     *   copy, print, modify, annot-forms
     *   If a value is present it means that the permission is granted
     * - If a user password is set, user will be prompted before document is opened
     * - If an owner password is set, document can be opened in privilege mode with no
     *   restriction if that password is entered
     */
    public function SetProtection($permissions = array(), $user_pass = '', $owner_pass = null)
    {
        $options = array('print' => 4, 'modify' => 8, 'copy' => 16, 'annot-forms' => 32);
        $protection = 192;
        foreach ($permissions as $permission) {
            if (!isset($options[$permission])) {
                $this->Error('Incorrect permission: ' . $permission);
            }

            $protection += $options[$permission];
        }
        if ($owner_pass === null) {
            $owner_pass = uniqid(rand());
        }

        $this->encrypted = true;
        $this->padding = "\x28\xBF\x4E\x5E\x4E\x75\x8A\x41\x64\x00\x4E\x56\xFF\xFA\x01\x08" .
            "\x2E\x2E\x00\xB6\xD0\x68\x3E\x80\x2F\x0C\xA9\xFE\x64\x53\x69\x7A";
        $this->_generateencryptionkey($user_pass, $owner_pass, $protection);
    }

    /****************************************************************************
     *                                                                           *
     *                              Private methods                              *
     *                                                                           *
     ****************************************************************************/

    public function _putstream($s)
    {
        if ($this->encrypted) {
            $s = RC4($this->_objectkey($this->n), $s);
        }

        parent::_putstream($s);
    }

    public function _textstring($s)
    {
        if (!$this->_isascii($s)) {
            $s = $this->_UTF8toUTF16($s);
        }

        if ($this->encrypted) {
            $s = RC4($this->_objectkey($this->n), $s);
        }

        return '(' . $this->_escape($s) . ')';
    }

    /**
     * Compute key depending on object number where the encrypted data is stored
     */
    public function _objectkey($n)
    {
        return substr($this->_md5_16($this->encryption_key . pack('VXxx', $n)), 0, 10);
    }

    public function _putresources()
    {
        parent::_putresources();
        if ($this->encrypted) {
            $this->_newobj();
            $this->enc_obj_id = $this->n;
            $this->_put('<<');
            $this->_putencryption();
            $this->_put('>>');
            $this->_put('endobj');
        }
    }

    public function _putencryption()
    {
        $this->_put('/Filter /Standard');
        $this->_put('/V 1');
        $this->_put('/R 2');
        $this->_put('/O (' . $this->_escape($this->Ovalue) . ')');
        $this->_put('/U (' . $this->_escape($this->Uvalue) . ')');
        $this->_put('/P ' . $this->Pvalue);
    }

    public function _puttrailer()
    {
        parent::_puttrailer();
        if ($this->encrypted) {
            $this->_put('/Encrypt ' . $this->enc_obj_id . ' 0 R');
            $this->_put('/ID [()()]');
        }
    }

    /**
     * Get MD5 as binary string
     */
    public function _md5_16($string)
    {
        return md5($string, true);
    }

    /**
     * Compute O value
     */
    public function _Ovalue($user_pass, $owner_pass)
    {
        $tmp = $this->_md5_16($owner_pass);
        $owner_RC4_key = substr($tmp, 0, 5);
        return RC4($owner_RC4_key, $user_pass);
    }

    /**
     * Compute U value
     */
    public function _Uvalue()
    {
        return RC4($this->encryption_key, $this->padding);
    }

    /**
     * Compute encryption key
     */
    public function _generateencryptionkey($user_pass, $owner_pass, $protection)
    {
        // Pad passwords
        $user_pass = substr($user_pass . $this->padding, 0, 32);
        $owner_pass = substr($owner_pass . $this->padding, 0, 32);
        // Compute O value
        $this->Ovalue = $this->_Ovalue($user_pass, $owner_pass);
        // Compute encyption key
        $tmp = $this->_md5_16($user_pass . $this->Ovalue . chr($protection) . "\xFF\xFF\xFF");
        $this->encryption_key = substr($tmp, 0, 5);
        // Compute U value
        $this->Uvalue = $this->_Uvalue();
        // Compute P value
        $this->Pvalue = -(($protection ^ 255) + 1);
    }

    public function myCell($w, $h, $x, $t)
    {
        $height = $h / 3;
        $first = $height + 2;
        $second = $height + $height + $height + 3;
        $len = strlen($t);
        if ($len > 15) {
            $txt = str_split($t, 15);
            $this->SetX($x);
            $this->Cell($w, $first, $txt[0], '', '', '');
            $this->SetX($x);
            $this->Cell($w, $second, $txt[1], '', '', '');
            $this->SetX($x);
            $this->Cell($w, $h, '', 'LTRB', 0, 'L', 0);
        } else {
            $this->SetX($x);
            $this->Cell($w, $h, $t, 'LTRB', 0, 'L', 0);
        }
    }
    public $widths;
    public $aligns;

    public function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    public function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    public function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }

        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    public function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }

    }

    public function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }

        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }

            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }

                } else {
                    $i = $sep + 1;
                }

                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }

        }
        return $nl;
    }
}
