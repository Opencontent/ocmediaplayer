<?php

class OCMediaPlayerHelper
{
    public static function js( $file )
    {
        $ezjscoreIni = eZINI::instance( 'ocmediaplayer.ini' );
        if ( $ezjscoreIni->variable( 'OCMediaPlayer', 'LoadFromCDN' ) === 'enabled' )
        {
            $scriptFiles = $ezjscoreIni->variable( 'OCMediaPlayer', 'ExternalScriptsJs' );
            $packerFile = $scriptFiles[$file];
        }
        else
        {
            $scriptFiles = $ezjscoreIni->variable( 'OCMediaPlayer', 'LocalScriptsJs' );
            $packerFile = $scriptFiles[$file];
        }
        return $packerFile;
    }
    
    public static function flash( $file )
    {
        $ezjscoreIni = eZINI::instance( 'ocmediaplayer.ini' );
        if ( $ezjscoreIni->variable( 'OCMediaPlayer', 'LoadFromCDN' ) === 'enabled' )
        {
            $scriptFiles = $ezjscoreIni->variable( 'OCMediaPlayer', 'ExternalScriptsFlash' );
            $returnFile = $scriptFiles[$file];
        }
        else
        {
            $scriptFiles = $ezjscoreIni->variable( 'OCMediaPlayer', 'LocalScriptsFlash' );
            $returnFile = $scriptFiles[$file];
        }
        
        $bases = eZTemplateDesignResource::allDesignBases();
        $triedFiles = array();
        $match = eZTemplateDesignResource::fileMatch( $bases, '', 'flash/' . $returnFile, $triedFiles );
        if ( $match === false )
        {
            eZDebug::writeWarning( "Could not find: $file", __METHOD__ );
            return;
        }
        $returnFile = htmlspecialchars( $match['path'] );
        eZURI::transformURI( $returnFile, true, 'relative' );
        return $returnFile;
    }
    
   

}

?>
