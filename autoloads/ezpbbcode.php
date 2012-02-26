<?php
/**
 * File containing the eZBBCode class.
 *
 * @copyright Copyright (C) 2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 * @package ezautosave
 * @author carlos.revillo@tantacom.com
 */

/**
 * This class implements the parsing of bbcode usign 
 * third party sofware nbbc
 * @see http://nbbc.sourceforge.net/
 */

class ezpBBCode
{
    function __construct()
    {
    }

    function operatorList()
    {
        return array( 'bbcodetohtml' );
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array( 'bbcodetohtml' => array( ) );
    }

    function modify( $tpl, $operatorName, $operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'bbcodetohtml':
            {   
                // ezoe will can output with paragraphs in it, 
                // so we change them to bbcode notation too
                $tags = array( '<p>', '</p>' );
                $replacement = array( '[p]', "[/p]" );
                $operatorValue = str_replace( $tags, $replacement, $operatorValue );
                 
                // now we create a rule for parsing those [p][/p] parts               
                $new_rule = Array(
                    'simple_start' => '<p>',
                    'simple_end' => '</p>',
                );
                
                $bbcode = new BBCode;
                // add the rule
                $bbcode->addRule( 'p', $new_rule );
                
                // ...and parsing
                $operatorValue = $bbcode->parse( $operatorValue );               
       
            } break;
        }
    }
}

?>
