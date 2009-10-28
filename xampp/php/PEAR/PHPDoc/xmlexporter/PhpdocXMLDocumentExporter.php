<?php
/**
* Base of the class and module exporter.
* 
* @version $Id: PhpdocXMLDocumentExporter.php,v 1.2 2001/12/13 10:37:52 hayk Exp $
*/
class PhpdocXMLDocumentExporter extends PhpdocXMLExporter {
    
    /**
    * Mapping from internal result array index name to xml tag name.
    *
    * @var  array   $docTags
    */
    var $docTags = array(
                            "desc"      => "description",
                            "sdesc"     => "shortdescription",
                            
                            "version"   => "version",
                            "since"     => "since",
                            "version"   => "version",
                            "deprec"    => "deprecated",
                            "copyright" => "copyright",
                            "exclude"   => "exclude",
                            "brother"   => "brother",
                            "magic"     => "magic"
                        );

    /**
    * Attributes of the <see> container.
    *
    * @var  array
    */                                            
    var $seeAttributes = array(
                                "type"  => "CDATA",
                                "group" => "CDATA"
                            );
    
    /**
    * Attributes of the <link> container.
    *
    * @var  array
    */
    var $linkAttributes = array( "url"    => "CDATA" );

    /**
    * Attributes of the <author> container.
    *
    * @var  array
    */                                                        
    var $authorAttributes = array( "email"    => "CDATA" );
                                                            
    /**
    * Attributes of <inherited> and <overriden> container.
    *
    * @var  array
    */                                                            
    var $inheritedOverridenAttributes = array(
                                                "src"   => "CDATA",
                                                "type"  => "CDATA"
                                         );                                    

    /**
    * Attributes of the <constant> container.
    *
    * @var  array
    */                                                                                
    var $constAttributes = array(
                                    "name"      => "CDATA",
                                    "undoc"     => "Boolean",
                                    "access"    => "CDATA",
                                    "case"      => "CDATA"
                                );

    /**
    * Attribues of the <uses> container.
    *
    * @var  array
    */                                                            
    var $usesAttributes = array(
                                "type"  => "CDATA",
                                "file"  => "CDATA",
                                "undoc" => "Boolean"
                        );
                                                    
    /**
    * Attribues of the <function> container.
    *
    * @var  array
    */                                                        
    var $functionAttributes = array(
                                    "name"      => "CDATA",
                                    "undoc"     => "Boolean",
                                    "access"    => "CDATA",
                                    "abstract"  => "Boolean",
                                    "static"    => "CDATA"
                                );

    /**
    * Attributes of the <return> container.
    *
    * @var  array
    */                                                                
    var $returnAttributes = array( 
                                    "name"  => "CDATA",
                                    "type"  => "CDATA"
                                );            

    /**
    * Attributes of the <global> container.
    *
    * @var  array
    */                                                            
    var $globalAttributes = array(
                                    "name"  => "CDATA",
                                    "type"  => "CDATA"
                                );            

    /**
    * Attributes of the <param> container.
    *
    * @var  array
    */                                                            
    var $paramAttributes    = array(
                                    "name"      => "CDATA",
                                    "default"   => "CDATA",
                                    "type"      => "CDATA",
                                    "undoc"     => "Boolean"
                                );    
    
    /**
    * Writes a <file> container.
    *
    * @param    string  $file   Filename
    */
    function filenameXML($file) {
        $this->xmlwriter->addElement("file", $file);
    } // end func filenameXML
    
    /**
    * Adds all constants (define(), const) to the xml document.
    *
    * @param    array   Array of constants
    * @return   boolean Returns false on failure otherwise true
    */
    function constsXML($consts) {
        if (!is_array($consts) || 0 == count($consts)) 
            return true;
    
        reset($consts);
        while (list($k, $data)=each($consts)) {
        
            $attribs = $this->getAttributes($data, $this->constAttributes);
            $this->xmlwriter->startElement("constant", (isset($data["value"])) ? $data["value"] : "", $attribs, false, true);
            $this->docXML($data);
            $this->xmlwriter->endElement("constant", true);
            
        }
        
        return true;
    } // end func constsXML
    
    /**
    * Adds a list of used files (include, require...) to the xml document.
    * 
    * @param    array
    */
    function usesXML($uses) {
        if (!is_array($uses)) {
            $this->err[] = new PhpdocError("No array given.", __FILE__, __LINE__);
            return false;
        }
    
        reset($uses);
        while (list($k, $data) = each($uses)) {
        
            $attribs = $this->getAttributes($data, $this->usesAttributes);
            $this->xmlwriter->startElement("uses", "", $attribs, false, true);
            $this->docXML($data);    
            $this->xmlwriter->endElement("uses", true);
            
        }
        
        return true;
    } // end func usesXML
    
    /**
    * Adds a list of functions to the xml file.
    * 
    * @param    array
    */
    function functionsXML($functions) {
        if (!is_array($functions)) {
            $this->err[] = new PhpdocError("No array given.", __FILE__, __LINE__);
            return false;
        }

        reset($functions);
        while (list($k, $data) = each($functions)) {
        
            $attribs = $this->getAttributes($data, $this->functionAttributes);                    
            $this->xmlwriter->startElement("function", "", $attribs, false, true);
            $this->docXML($data);        
            $this->xmlwriter->endElement("function", true);
            
        }
                                                            
    } // end functionsXML
    
    /**
    * Adds a documentation block (author, links, see, params...) to the xml document
    * 
    * @param    array
    */
    function docXML($data) {
        
        $this->xmlwriter->startElement("doc", "", "", false, true);
        
        if (isset($data["link"]))
            $this->linkXML($data["link"]);        
        
        if (isset($data["author"]))
            $this->authorXML($data["author"]);
            
        if (isset($data["see"]))
            $this->seeXML($data["see"]);
            
        if (isset($data["params"]))
            $this->paramsXML($data["params"]);
            
        if (isset($data["return"]))
            $this->returnXML($data["return"]);
            
        if (isset($data["throws"])) 
            $this->throwsXML($data["throws"]);
        
        if (isset($data["global"]))
            $this->globalsXML($data["global"]);

        if (isset($data["inherited"])) {
            
            
            $attribs = array(
                                "src"    => array(
                                                    "type"  => $this->inheritedOverridenAttributes["src"],
                                                    "value" => $data["inherited"]
                                                )
                                            );
            $this->xmlwriter->addElement("inherited", "", $attribs);
        }
        
        if (isset($data["overrides"])) {
            $attribs = array( 
                            "src"    => array(
                                                "type"    => $this->inheritedOverridenAttributes["src"],
                                                "value"    => $data["overrides"]
                                            )
                            );
            $this->xmlwriter->addElement("overriden", "", $attribs);                                            
        }
            
        reset($this->docTags);
        while (list($field, $tag) = each($this->docTags))
            if (isset($data[$field]))
                $this->xmlwriter->addElement($tag, $data[$field], "");
            
        $this->xmlwriter->endElement("doc", true);
    } // end func docXML

    /**
    * Adds <global> container to the xml document.
    * 
    * @param    array
    */
    function globalsXML($globals) {
    
        reset($globals);
        while (list($k, $data) = each($globals)) {
            $attribs = $this->getAttributes($data, $this->globalAttributes);
            $this->xmlwriter->addElement("global", (isset($data["desc"])) ? $data["desc"] : "", $attribs);
        }
        
    } // end func globalsXML
    
    /**
    * Adds <throws> container to the xml document.
    * 
    * @param    array
    */
    function throwsXML($exceptions) {
        
        reset($exceptions);
        while (list($k, $exception) = each($exceptions)) 
            $this->xmlwriter->addElement("throws", $exception, "", true);
        
    } // end func throwsXML
    
    /**
    * Adds <return> container to the xml document.
    * 
    * @param    array
    */
    function returnXML($return) {

        $desc = "";    
        
        if (is_array($return)) {
        
            if (isset($return["desc"])) {
                $desc = $return["desc"];
                unset($return["desc"]);
            }
            $attribs = $this->getAttributes($return, $this->returnAttributes);
            
        } else {
        
            $attribs["type"] = array( "type"    => "CDATA", "value"    => $return );
            
        }
        
        $this->xmlwriter->addElement("return", $desc, $attribs);
        
    } // end func returnXML    
    
    /**
    * Adds <parameter> container to the xml document.
    * 
    * @param    array
    */
    function paramsXML($params) {
    
        reset($params);
        while (list($k, $data) = each($params)) {
            $attribs = $this->getAttributes($data, $this->paramAttributes);
            $this->xmlwriter->addElement("parameter", (isset($data["desc"])) ? $data["desc"] : "", $attribs);
        }

    } // end func paramsXML
    
    /**
    * Adds <author> container to the xml document.
    *
    * @param    array
    */
    function authorXML($authors) {
        
        reset($authors);
        while (list($k, $data) = each($authors)) {
            
            $attribs = array();
            
            if (isset($data["mail"]))
                $attribs = array(
                                    "email"    => array(
                                                        "type"  => $this->authorAttributes["email"],
                                                        "value" => $data["mail"]
                                                    )
                                );
            $this->xmlwriter->addElement("author",$data["name"], $attribs);
                                                                            
        }
            
    } // end func authorXML
    
    /**
    * Adds <link> container to the xml document.
    *
    * @param    array
    */
    function linkXML($links) {
        
        reset($links);
        while (list($k, $data) = each($links)) {
        
            $attribs = array(
                                "url"    => array(
                                                    "type"  => $this->linkAttributes["url"],
                                                    "value" => $data["url"]
                                                )
                            );
            $this->xmlwriter->addElement("link",  (isset($data["desc"])) ? $data["desc"] : "", $attribs);                                                
            
        }
        
    } // end func linkXML
    
    /**
    * Adds <see> container to the xml document.
    * 
    * @param    array
    */
    function seeXML($see) {
        
        reset($see);
        while (list($type, $data) = each($see)) {
            
            reset($data);
            while (list($k, $data2) = each($data)) {
            
                $attribs = array(
                                "type"    => array(
                                                    "type"  => $this->seeAttributes["type"],
                                                    "value" => strtolower($type)
                                                )
                            );
                if (isset($data2["group"]))
                    $attribs["group"] = array(
                                                "type"  => $this->seeAttributes["group"],
                                                "value" => $data2["group"]
                                            );
                                                                    
                $this->xmlwriter->addElement("see", $data2["name"], $attribs);
                
            }
                                                        
        }
        
    } // end func SeeXML

} // end class PhpdocXMLDocumentExporter
?>