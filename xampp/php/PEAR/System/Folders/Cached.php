<?php
/**
*   Provides a cached version of System_Folders.
*   It also has methods to read folder settings from an ini file.
*
*   Simpe example:
*       require_once 'System/Folders/Cached.php';
*       $sf = new System_Folders_Cached();
*
*       //load the stored settings from last time
*       $sf->loadFromFile();
*       echo $sf->getHome();
*
*       //Set an own documents directory
*       $sf->setDocuments('/home/cweiske/MyDocuments/');
*       //Save the settings for next time
*       $sf->saveToFile();
*
*
*   @category   System
*   @package    System_Folders
*   @author     Christian Weiske <cweiske@php.net>
*   @license    LGPL
*   @version    CVS: $Id: Cached.php,v 1.1 2006/03/10 13:04:26 cweiske Exp $
*/

require_once 'System/Folders.php';
require_once 'Config.php';
require_once 'Config/Container.php';

/**
*   Provides a cached version of System_Folders.
*   It also has methods to read folder settings from an ini file.
*
*   Be very careful when overriding the AppData setting with
*    setAppData()! When loading a config file without specifying the file
*    name, the default app data directory will be used. After loading,
*    the file will be saved to the new app data directory, thus it won't
*    be available the next time, as the app data folder is the old one again.
*
*   @category   System
*   @package    System_Folders
*   @author     Christian Weiske <cweiske@php.net>
*   @license    LGPL
*   @version    CVS: $Id: Cached.php,v 1.1 2006/03/10 13:04:26 cweiske Exp $
*/
class System_Folders_Cached extends System_Folders
{
    /**
    *   The cached paths will be hold here.
    *
    *   @access protected
    *   @var array
    */
    var $arCache = array();

    /**
    *   The settings that are available.
    *
    *   @access protected
    *   @var array
    */
    var $arSettings = array(
        'AllUsers', 'AppData', 'Desktop', 'Documents', 'Home',
        'Programs', 'Temp', 'SharedDocuments', 'Windows'
    );



    function System_Folders_Cached()
    {
        parent::System_Folders();
    }//function System_Folders_Cached()



    /**
    *   Loads the directories from an ini file.
    *   If you don't specify the config file, it will be determined
    *    automatically.
    *
    *   @access public
    *   @param string   $strFile    The file to load the data from (ini file)
    *   @return mixed   True on success, PEAR_Error on failure
    */
    function loadFromFile($strFile = null)
    {
        $strFile = $this->getDefaultConfigFile();
        if (!file_exists($strFile)) {
            //Not existing config file isn't an error
            return true;
        }
        $conf = new Config();
        $root =& $conf->parseConfig($strFile, 'inifile');

        if (PEAR::isError($root)) {
            return $root;
        }

        $arSettings = $root->toArray();
        if (!isset($arSettings['root']['paths'])) {
            return true;
        }

        foreach ($arSettings['root']['paths'] as $strId => $strValue) {
            if ($strValue != '') {
                $this->arCache[$strId] = $strValue;
            }
        }

        return true;
    }//function loadFromFile($strFile = null)



    /**
    *   Saves the folders into a config file that can be edited by hand.
    *   If you don't specify the config file, it will be determined
    *    automatically.
    *   Values that are NULL won't be saved.
    *
    *   @access public
    *   @param string   $strFile    The file to save the data into (ini file)
    *   @param boolean  $bSaveAllSettings   If all settings shall be saved
    *                           that can be loaded, or only that settings,
    *                           that have been retrieved by the user
    *   @return mixed   True on success, PEAR_Error on failure
    */
    function saveToFile($strFile = null, $bSaveAllSettings = true)
    {
        $conf  =& new Config_Container('section', 'paths');

        if ($bSaveAllSettings) {
            foreach ($this->arSettings as $strSetting) {
                $strFunction = 'get' . $strSetting;
                $strValue = $this->$strFunction();
                $conf->createDirective(strtolower($strSetting), $strValue);
            }
        } else {
            foreach ($this->arCache as $strId => $strValue) {
                $conf->createDirective($strId, $strValue);
            }
        }

        $config = new Config();
        $config->setRoot($conf);
        return $config->writeConfig($this->getDefaultConfigFile(), 'inifile');
    }//function saveToFile($strFile = null, $bSaveAllSettings = true)



    /**
    *   Returns the path to the default config file.
    *   It the one that's used if no filename is passed to the
    *    saveToFile/loadFromFile methods.
    *
    *   @access public
    *   @return string  The filename
    */
    function getDefaultConfigFile()
    {
        return $this->getAppData() . '/.net.php.pear.system.folders';
    }//function getDefaultConfigFile()



    /**
    *   Returns a cached value.
    *   If the cache doesn't exist, the cached value is empty or null,
    *   the System_Folders method for the key is called to get the value.
    *
    *   @access protected
    *   @param string $strKey   The id of the value to get
    *   @return string      The directory
    */
    function getCachedValue($strKey)
    {
        $strKeyLower = strtolower($strKey);
        if (!isset($this->arCache[$strKeyLower])) {
            $strFunction = 'get' . $strKey;
            $this->arCache[$strKeyLower] = parent::$strFunction();
        }

        return $this->arCache[$strKeyLower];
    }//function getCachedValue($strKey)



    /**
    *   Sets the cache of the given key to the given value.
    *   Passing NULL removes the cache entry.
    *
    *   @access protected
    *   @param string $strKey       Id of the value to get
    *   @param string $strValue     Value to set.
    */
    function setCachedValue($strKey, $strValue)
    {
        if ($strValue === null) {
            unset($this->arCache[strtolower($strKey)]);
        } else {
            $this->arCache[strtolower($strKey)] = $strValue;
        }
    }//function setCachedValue($strKey, $strValue)



    /*
    *   Overriding the parent's methods to cache them
    */



    /**
    *   Cached version of getAllUsers().
    *
    *   @access public
    *   @see System_Folders::getAllUsers()
    *   @return string      The all users directory
    */
    function getAllUsers()
    {
        return $this->getCachedValue('AllUsers');
    }//function getAllUsers()



    /**
    *   Cached version of getAppData().
    *
    *   @access public
    *   @see System_Folders::getAppData()
    *   @return string      The application data directory
    */
    function getAppData()
    {
        return $this->getCachedValue('AppData');
    }//function getAppData()



    /**
    *   Cached version of getDesktop().
    *
    *   @access public
    *   @see System_Folders::getDesktop()
    *   @return string      The desktop directory
    */
    function getDesktop()
    {
        return $this->getCachedValue('Desktop');
    }//function getDesktop()



    /**
    *   Cached version of getDocuments().
    *
    *   @access public
    *   @see System_Folders::getDocuments()
    *   @return string      The documents directory
    */
    function getDocuments()
    {
        return $this->getCachedValue('Documents');
    }//function getDocuments()



    /**
    *   Cached version of getHome().
    *
    *   @access public
    *   @see System_Folders::getHome()
    *   @return string      The home directory
    */
    function getHome()
    {
        return $this->getCachedValue('Home');
    }//function getHome()



    /**
    *   Cached version of getPrograms().
    *
    *   @access public
    *   @see System_Folders::getPrograms()
    *   @return string      The programs directory
    */
    function getPrograms()
    {
        return $this->getCachedValue('Programs');
    }//function getPrograms()



    /**
    *   Cached version of getTemp().
    *
    *   @access public
    *   @see System_Folders::getTemp()
    *   @return string      The temporary directory
    */
    function getTemp()
    {
        return $this->getCachedValue('Temp');
    }//function getTemp()



    /**
    *   Cached version of getSharedDocuments().
    *
    *   @access public
    *   @see System_Folders::getSharedDocuments()
    *   @return string      The shared documents directory
    */
    function getSharedDocuments()
    {
        return $this->getCachedValue('SharedDocuments');
    }//function getSharedDocuments()



    /**
    *   Cached version of getWindows().
    *
    *   @access public
    *   @see System_Folders::getWindows()
    *   @return string      The windows directory
    */
    function getWindows()
    {
        return $this->getCachedValue('Windows');
    }//function getWindows()



    /*
    *   Setter methods
    */



    /**
    *   Sets an own all users directory.
    *   Set it to NULL to deactivate saving and
    *    remove the value from the cache.
    *
    *   @access public
    *   @see getAllUsers
    *   @param string $value    The new all users directory
    */
    function setAllUsers($value)
    {
        $this->setCachedValue('AllUsers', $value);
    }//function setAllUsers($value)



    /**
    *   Sets an own application data directory.
    *   Set it to NULL to deactivate saving and
    *    remove the value from the cache.
    *
    *   @access public
    *   @see getAppData
    *   @param string $value    The new app data directory
    */
    function setAppData($value)
    {
        $this->setCachedValue('AppData', $value);
    }//function setAppData($value)



    /**
    *   Sets an own desktop directory.
    *   Set it to NULL to deactivate saving and
    *    remove the value from the cache.
    *
    *   @access public
    *   @see getDesktop
    *   @param string $value    The new desktop directory
    */
    function setDesktop($value)
    {
        $this->setCachedValue('Desktop', $value);
    }//function setDesktop($value)



    /**
    *   Sets an own documents directory.
    *   Set it to NULL to deactivate saving and
    *    remove the value from the cache.
    *
    *   @access public
    *   @see getDocuments
    *   @param string $value    The new documents directory
    */
    function setDocuments($value)
    {
        $this->setCachedValue('Documents', $value);
    }//function setDocuments($value)



    /**
    *   Sets an own home directory.
    *   Set it to NULL to deactivate saving and
    *    remove the value from the cache.
    *
    *   @access public
    *   @see getHome
    *   @param string $value    The new home directory
    */
    function setHome($value)
    {
        $this->setCachedValue('Home', $value);
    }//function setHome($value)



    /**
    *   Sets an own programs directory.
    *   Set it to NULL to deactivate saving and
    *    remove the value from the cache.
    *
    *   @access public
    *   @see getPrograms
    *   @param string $value    The new programs directory
    */
    function setPrograms($value)
    {
        $this->setCachedValue('Programs', $value);
    }//function setPrograms($value)



    /**
    *   Sets an own temp directory.
    *   Set it to NULL to deactivate saving and
    *    remove the value from the cache.
    *
    *   @access public
    *   @see getTemp
    *   @param string $value    The new temp directory
    */
    function setTemp($value)
    {
        $this->setCachedValue('Temp', $value);
    }//function setTemp($value)



    /**
    *   Sets an own shared documents directory.
    *   Set it to NULL to deactivate saving and
    *    remove the value from the cache.
    *
    *   @access public
    *   @see getSharedDocuments
    *   @param string $value    The new shared documents directory
    */
    function setSharedDocuments($value)
    {
        $this->setCachedValue('SharedDocuments', $value);
    }//function setSharedDocuments($value)



    /**
    *   Sets an own windows directory.
    *   Set it to NULL to deactivate saving and
    *    remove the value from the cache.
    *
    *   @access public
    *   @see getWindows
    *   @param string $value    The new windows directory
    */
    function setWindows($value)
    {
        $this->setCachedValue('Windows', $value);
    }//function setWindows($value)

}//class System_Folders_Cached extends System_Folders
?>
