<?php
/**
* Extract class variables and their documentation from phpcode
*
* @version  $Id: PhpdocVariableParser.php,v 1.1 2001/05/08 04:48:38 sbergmann Exp $
*/
class PhpdocVariableParser extends PhpdocModuleParser {

    /**
    * Array with default values of a variable
    * 
    * @var    array        $emptyVariable
    */
    var $emptyVariable = array(
                                "name"  => "",
                                "undoc" => true
                          );

    /**
    * Array of tags that are allowed in front of the var keyword
    *
    * @var    array    $variableTags
    * @see    analyseVariableParagraph()
    */
    var $variableTags = array(
                                "access"        => true,
                                "abstract"      => true,
                                "static"        => true,
                                "final"         => true,
                                
                                "see"           => true,
                                "link"          => true,
                                
                                "var"           => true,
                                
                                "version"       => true,
                                "since"         => true,
                                
                                "deprecated"    => true,
                                "deprec"        => true,
                                
                                "brother"       => true, 
                                "sister"        => true,
                                
                                "exclude"       => true,
                                "magic"         => true,
                                "todo"          => true
                          );

    /**
    * Analyses a variable doc comment
    *
    * @param    array    Hash returned by getPhpdocParagraph()
    * @return   array 
    */                                            
  function analyseVariable($para) {
        
        $variable = $this->emptyVariable;
        $variable["name"] = $para["name"];
        
        if ("" != $para["doc"]) {
            
            $variable = $this->analyseTags($this->getTags($para["doc"]), $variable, $this->variableTags);
            
            list($msg, $variable) = $this->checkParserErrors($variable, "variable");
            if ("" != $msg)
                $this->warn->addDocWarning($this->currentFile, "variable", $variable["name"], $msg, "mismatch");
                
            list($variable["sdesc"], $variable["desc"]) = $this->getDescription($para["doc"]);
            
            $variable["undoc"] = false;
            
        }
        
        list($type, $value, $raw_value) = $this->getVariableTypeAndValue($para["value"], false);
        $variable["type"]     = $type;
        
        if ("unknown" != $value) 
            $variable["value"] = $value;
        
        $variable = $this->checkVarDocs($variable);
        
        return $variable;
    } // end func analyseVariables
    
    /**
    * Compares the var tag informations with the analyse of the source code.
    *
    * @param    array   $variable
    * @return   array   $variable
    */
    function checkVarDocs($variable) {
        
        if (!isset($variable["var"]))
            return $variable;
            
        if ("unknown" != $variable["type"] && "mixed" != $variable["type"] && $variable["var"]["type"] != $variable["type"]) {
            
            $msg = sprintf("The documented class variable type does not match the type found. Update the tag to '@var %s [%s]%s'.",
                            $variable["type"],
                            $variable["name"],
                            (isset($variable["var"]["desc"])) ? " " . $variable["var"]["desc"] : ""
                        );
            $this->warn->addDocWarning($this->currentFile, "variable", $variable["name"], $msg, "mismatch");
            
        } else if ("unknown" == $variable["type"] && "" != $variable["var"]["type"]) {
            
            $variable["type"] = $variable["var"]["type"];
            
        }
        
        if ("" != $variable["var"]["name"] && $variable["var"]["name"] != $variable["name"]) {
            
            $msg = sprintf("The documented class variable name does not match the name found. Update the tag to '@var %s [%s]%s'.",
                            ("" != $variable["var"]["type"]) ? $variable["var"]["type"] : $variable["type"],
                            $variable["name"],
                            (isset($variable["var"]["desc"])) ? " " . $variable["var"]["desc"] : ""
                        );
            $this->warn->addDocWarning($this->currentFile, "variable", $variable["name"], $msg, "mismatch");
        }
        
                
        unset($variable["var"]);
        
        return $variable;
    } // end func checkVarDocs

} // end class PhpdocVariableParser
?>