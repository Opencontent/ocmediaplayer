<?php

class OCMPOperator
{

	function operatorList()
	{
		return array( 'ocmp', 'oneline' );
	}

	function namedParameterPerOperator()
	{
		return true;
	}

	function namedParameterList()
	{
		return array(
			'ocmp' => array(
                'fileIdentifier' => array( 'type' => 'string', 'required' => true ),
                'fileType' => array( 'type' => 'string', 'required' => false, 'default' => 'js' ),
                'dash' => array( 'type' => 'boolean', 'required' => false, 'default' => false ),
            )
		);
	}
		

	function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
	{

		switch ( $operatorName )
		{
			case 'ocmp':
                $function = $namedParameters['fileType'];
                if ( method_exists( 'OCMediaPlayerHelper', $function ) )
                {
                    $value = OCMediaPlayerHelper::$function( $namedParameters['fileIdentifier'] );
                    
                    $dash = $namedParameters['dash'];
                    
                    if ( !$dash && $function == 'flash' )
                    {
                        $dash = true;
                    }
                    
                    if ( $dash )
                        return $operatorValue = '"' . $value . '"';
                    else
                        return $operatorValue = $value;
                }
                break;
            
            case 'oneline':
                $operatorValue = str_replace( "\n", ' ', $operatorValue );
                $operatorValue = str_replace( "\r", ' ', $operatorValue );
                return $operatorValue;
                break;
                
            default:
			$operatorValue = false;
        }
	}
}

?>
