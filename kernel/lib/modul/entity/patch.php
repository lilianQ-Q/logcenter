<?php

$patch_path = "data/patch/";
define("PATCH_PATH", $patch_path);

class Patch{
  private $url;
  private $content;
  private $modified;

  /**
   * Default constructor of Patch class.
   */
  public function __construct()
  {
    $this->url = "unknow";
    $this->content = "none";
    $this->modified = "9999";
  }

  /**
   * Method that allow the user to set all data of a Patch object. 
   * The current object will be updated if the file has been found.
   * 
   * @param string $name is the name / version of the patch.
   */
  public function setAll($name){
    if(file_exists(PATCH_PATH . $name . ".md")){
      $this->url = PATCH_PATH . $name . ".md";
      $this->content = file_get_contents($this->url);
      $this->modified = filectime($this->url);
    }
  }

  /**
   * Method that allow the user to set the url of the Patch's path.
   * 
   * @param string $name is the name / version of the patch
   */
  private function setUrl($name){
    if(file_exists(PATCH_PATH . $name)){
      $this->url = PATCH_PATH . $name;
    }
  }

  /**
   * Method that allow the user to set the Patch's content.
   * 
   * @param string $content is the content of the Patch.
   */
  private function setContent($content){
    $this->content = $content;
  }

  /**
   * Method that allow the user to set the patch last save date.
   * 
   * @param string modified is the modified date of the patch. Format (m-d-Y).
   */
  private function setModified($modified){
    $this->modified = $modified;
  }

  /**
   * Method that allow the user to get the Patch's url.
   * 
   * @return string Patch's url.
   */
  public function getUrl(){
    return($this->url);
  }

  /**
   * Method that allow the user to get the Patch's content.
   * 
   * @return string Patch's content.
   */
  public function getContent(){
    return($this->content);
  }

  /**
   * Method that allow the user to get the Patch's last modified date.
   * 
   * @return string Patch's last modified date. Format (d-m-Y).
   */
  public function getModifiedDate(){
    return($this->modified);
  }

}

?>