<?php
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2004 Manuel Lemos, Tomas V.V.Cox,                 |
// | Stig. S. Bakken, Lukas Smith                                         |
// | All rights reserved.                                                 |
// +----------------------------------------------------------------------+
// | MDB is a merge of PEAR DB and Metabases that provides a unified DB   |
// | API as well as database abstraction for PHP applications.            |
// | This LICENSE is in the BSD license style.                            |
// |                                                                      |
// | Redistribution and use in source and binary forms, with or without   |
// | modification, are permitted provided that the following conditions   |
// | are met:                                                             |
// |                                                                      |
// | Redistributions of source code must retain the above copyright       |
// | notice, this list of conditions and the following disclaimer.        |
// |                                                                      |
// | Redistributions in binary form must reproduce the above copyright    |
// | notice, this list of conditions and the following disclaimer in the  |
// | documentation and/or other materials provided with the distribution. |
// |                                                                      |
// | Neither the name of Manuel Lemos, Tomas V.V.Cox, Stig. S. Bakken,    |
// | Lukas Smith nor the names of his contributors may be used to endorse |
// | or promote products derived from this software without specific prior|
// | written permission.                                                  |
// |                                                                      |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT    |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS    |
// | FOR A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE      |
// | REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,          |
// | INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, |
// | BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS|
// |  OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED  |
// | AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT          |
// | LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY|
// | WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE          |
// | POSSIBILITY OF SUCH DAMAGE.                                          |
// +----------------------------------------------------------------------+
// | Author: Lukas Smith <smith@backendmedia.com>                         |
// +----------------------------------------------------------------------+
//
// $Id: Date.php,v 1.14.4.1 2004/01/08 13:43:02 lsmith Exp $
//

/**
 * Several methods to convert the MDB native timestamp format (ISO based)
 * to and from data structures that are convienient to worth with in side of php.
 * For more complex date arithmetic please take a look at the Date package in PEAR
 *
 * @package MDB
 * @category Database
 * @author  Lukas Smith <smith@backendmedia.com>
 */
class MDB_Date
{
    // {{{ mdbNow()

    /**
     * return the current datetime
     *
     * @return string current datetime in the MDB format
     * @access public
     */
    function mdbNow()
    {
        return(date('Y-m-d H:i:s'));
    }

    // }}}
    // {{{ mdbToday()

    /**
     * return the current date
     *
     * @return string current date in the MDB format
     * @access public
     */
    function mdbToday()
    {
        return(date('Y-m-d'));
    }

    // }}}
    // {{{ mdbTime()

    /**
     * return the current time
     *
     * @return string current time in the MDB format
     * @access public
     */
    function mdbTime()
    {
        return(date('H:i:s'));
    }

    // }}}
    // {{{ date2Mdbstamp()

    /**
     * convert a date into a MDB timestamp
     *
     * @param integer $hour hour of the date
     * @param integer $minute minute of the date
     * @param integer $second second of the date
     * @param integer $month month of the date
     * @param integer $day day of the date
     * @param integer $year year of the date
     * @return string a valid MDB timestamp
     * @access public
     */
    function date2Mdbstamp($hour = NULL, $minute = NULL, $second = NULL,
        $month = NULL, $day = NULL, $year = NULL)
    {
        return MDB_Date::unix2Mdbstamp(mktime($hour, $minute, $second, $month, $day, $year));
    }

    // }}}
    // {{{ unix2Mdbstamp()

    /**
     * convert a unix timestamp into a MDB timestamp
     *
     * @param integer $unix_timestamp a valid unix timestamp
     * @return string a valid MDB timestamp
     * @access public
     */
    function unix2Mdbstamp($unix_timestamp)
    {
        return date('Y-m-d H:i:s', $unix_timestamp);
    }

    // }}}
    // {{{ mdbstamp2Unix()

    /**
     * convert a MDB timestamp into a unix timestamp
     *
     * @param integer $mdb_timestamp a valid MDB timestamp
     * @return string unix timestamp with the time stored in the MDB format
     * @access public
     */
    function mdbstamp2Unix($mdb_timestamp)
    {
        $arr = MDB_Date::mdbstamp2Date($mdb_timestamp);

        return mktime($arr['hour'], $arr['minute'], $arr['second'], $arr['month'], $arr['day'], $arr['year'], 0);
        }

    // }}}
    // {{{ mdbstamp2Date()

    /**
     * convert a MDB timestamp into an array containing all
     * values necessary to pass to php's date() function
     *
     * @param integer $mdb_timestamp a valid MDB timestamp
     * @return array with the time split
     * @access public
     */
    function mdbstamp2Date($mdb_timestamp)
    {
        list($arr['year'], $arr['month'], $arr['day'], $arr['hour'], $arr['minute'], $arr['second']) =
            sscanf($mdb_timestamp, "%04u-%02u-%02u %02u:%02u:%02u");
        return($arr);
    }

    // }}}
}

?>
