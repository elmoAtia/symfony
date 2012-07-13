<?php

/* LobamaSocial2PrintBundle:Default:options.html.twig */
class __TwigTemplate_1728ac29ef768d999f744be43d7b282e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "LobamaSocial2PrintBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "<div class=\"options\">
<form action=\"loading\">
<fieldset>
<legend>Style:</legend>
<input type=\"radio\" name=\"style\" value=\"classic\" checked=\"true\" /> Classic <br />
<input type=\"radio\" name=\"style\" value=\"polaroid\" disabled=\"disabled\" /> Polaroid <br />
<input type=\"radio\" name=\"style\" value=\"monochrome\" disabled=\"disabled\" /> Monochrome <br/>
<input type=\"radio\" name=\"style\" value=\"retro\" disabled=\"disabled\" /> Retro <br />
</fieldset>
<input type=\"submit\" name=\"submit\" value=\"Submit\" />
<fieldset>
<legend>Size:</legend>
<input type=\"radio\" name=\"size\" value=\"gridPhoto54\" checked=\"true\" /> 54 Photos <br />
<input type=\"radio\" name=\"size\" value=\"gridPhoto108\" /> 108 Photos
</fieldset>
</form>
</div>


";
    }

    public function getTemplateName()
    {
        return "LobamaSocial2PrintBundle:Default:options.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
