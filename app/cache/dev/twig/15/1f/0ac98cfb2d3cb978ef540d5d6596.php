<?php

/* LobamaSocial2PrintBundle:Default:breadcrumbs.html.twig */
class __TwigTemplate_151f0ac98cfb2d3cb978ef540d5d6596 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"breadcrumb\">
<span class=\"first ";
        // line 2
        if (($this->getContext($context, "current") == "index")) {
            echo " active";
        }
        echo "\"><a href=\"\">Poster Home</a></span>
<span class=\"arrow\">&nbsp;</span>
<span class=\"";
        // line 4
        if (($this->getContext($context, "current") == "preview")) {
            echo " active";
        }
        echo "\"><a href=\"preview\">Preview & Edit</a></span>
</div>  
<div class=\"clearfix\"></div>
";
    }

    public function getTemplateName()
    {
        return "LobamaSocial2PrintBundle:Default:breadcrumbs.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
