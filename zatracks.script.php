<?php
defined('_JEXEC') or die('Restricted access');


class PlgContentZatracksInstallerScript
{

    public function preflight($type)
    {
        if ($type != "discover_install" && $type != "install")
        {
            return true;
        }

        $version = new JVersion;

        if (version_compare($version->getShortVersion(), "3", 'lt'))
        {
            Jerror::raiseWarning(null, JText::_('PLG_CONTENT_ZATRACKS_INSTALL_NOJ2_ERROR'));

            return false;
        }

        return true;
    }

    public function install($parent)
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $path = $parent->getParent()->getPath('source');

        $src  = $path.'/layouts/zatracks';
        $dest = JPATH_SITE . '/layouts/joomla/zatracks';
        $retVal = JFolder::move($src, $dest, '');

        if( $retVal !== true )
        {
            JError::raiseWarning(100, $retVal);
        }
    }

    public function update($parent)
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $path  = $parent->getParent()->getPath('source');

        $src  = $path.'/layouts/zatracks';
        $dest = JPATH_SITE . '/layouts/joomla/zatracks';

        if(JFolder::exists($dest))
        {
            JFolder::delete($dest);
        }

        $retVal = JFolder::move($src, $dest, '');

        if( $retVal !== true )
        {
            JError::raiseWarning(100, $retVal);
        }

        JFactory::getApplication()->enqueueMessage(JText::_('PLG_CONTENT_ZATRACKS_UPDATE_NOTICE'), 'notice');

    }

    public function uninstall($parent)
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $folder  = JPATH_SITE . '/layouts/joomla/zatracks';

        if( JFolder::delete($folder) )
        {
            JFactory::getApplication()->enqueueMessage(JText::_('PLG_CONTENT_ZATRACKS_LAYOUTS_DELETED_NOTICE'), 'notice');
        }   
    }

    public function postflight($type, $parent) 
	{
		jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $path  = JPATH_SITE . '/plugins/content/zatracks/layouts/zatracks';

		if(JFolder::exists($path))
        {
        	JFolder::delete($path);
        }
	}

}