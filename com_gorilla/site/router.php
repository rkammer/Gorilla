<?php

/**
 * Gorilla Document Manager
 *
 * @author     Rodrigo Kammer
 * @copyright  2013-2014 SOHO Prospecting LLC (California - USA)
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link https://www.sohoprospecting.com
 *
 * Try not. Do or do not. There is no try.
 */


function getNotebookRoute($id){
    $db =& JFactory::getDBO();
    // $query  = $db->getQuery(true);
    // $query->select('CONCAT( `a`.`id`,  \'-\', `a`.`alias` ) AS  `route` ');
    // $query->from('`#__gorilla_notebooks` a');
    // $query->where('`a`.`id = '.$id);

    $db->setQuery("SELECT CONCAT( id,  '-', alias ) AS  `route` ".
                  "  FROM  `jos_gorilla_notebooks`              ".
                  " WHERE id = ".$id);

    return $db->loadResult();
}

function GorillaBuildRoute( &$query ){

    $segments = array();

    // if((isset($query['view'])) && ($query['view'] == 'notebooks')){
    //     $segments[] = 'list-of-notebooks';
    //     unset($query['view']);
    // }

    if((isset($query['view'])) && ($query['view'] == 'notebook')){
        $segments[] = 'notebook';
        $segments[] = getNotebookRoute($query['id']);
        unset($query['view']);
        unset($query['id']);
    } 
    

    return $segments;
}

function GorillaParseRoute( $segments ){

    $vars = array();
    switch($segments[0]){
        case 'notebook':
             $vars['view'] = 'notebook';
             $vars['id']   = (int) explode( '-', $segments[1] );
             break;
        // case 'list-of-notebooks':
        //      $vars['view'] = 'notebooks';             
        //      break;
    }
    return $vars;
}