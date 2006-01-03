<?php
/* Saiko Templating Class
    Originally engineered by Alex Melynk */
class Template
{
    var $_templateVars, $_vars;
    
    function Template($pageTitle)
    {
        $this->assignVar('pageTitle', $pageTitle);
    }
    
	function assignVar($varName, $varValue)
	{
		$this->_templateVars[$varName] = $varValue;
	}
	
    // Parse template syntax
    function _parse($file, $templateVars)
    {
        if(is_array($templateVars))
        {
            foreach($templateVars as $name => $value)
            {
                $this->_vars->$name = $value;
            }
        }
        
        if(!($fp = fopen($file, 'r')))
        {
            error('Cannot open template file : '.$file, __LINE__, __FILE__);
            exit();
        }
        $content = fread($fp, filesize($file));
        $content = str_replace('@', "\$this->_vars->", $content);
        $content = str_replace('[:', '<?php echo ', $content);
        $content = str_replace(':]', '; ?>', $content);
        eval('?>' . $content . '<?php ');
        unset($this->_vars);
    }
    
    // Display a template.
    function display($pageName)
    {
        global $settings;
        $file = 'templates/'.$settings['theme'].'/'.$pageName.'.html';
        $this->_parse($file, $this->_templateVars);
    }
}
/***
$t = new Template();
$t->display('header');
$t->display('blah');
$t->display('footer');
--
displayTemplate('template_name', 'page title', array('vars' => $values));
***/
?>