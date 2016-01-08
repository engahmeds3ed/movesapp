<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editor extends Main {
    
    public $editor = "";
    
    function __construct(){
        parent::__construct();
    }
    
    function loadeditor($editorname){
        
        if(!empty($editorname)){
            $folder = FCPATH.DIRECTORY_SEPARATOR."assets/editors/".$editorname;
            
            if(file_exists($folder)){
                $this->editor = $editorname;
                $this->loadfiles();
            }
        }
        
    }
    
    function loadfiles(){
        if(!empty($this->editor)){
            $this->data['scripts'][] = "../../editors/".$this->editor."/".$this->editor.".js";
            //$this->data['scripts'][] = "../../editors/".$this->editor."/index.js";
        }
    }
    
}