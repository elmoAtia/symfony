<?php

/* LobamaSocial2PrintBundle:Default:product.html.twig */
class __TwigTemplate_42596fa872e85c83123b1cf3e4281454 extends Twig_Template
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
        echo "<div class=\"product\">
<form action=\"options\">
<fieldset>
<legend>Product:</legend>
<input type=\"radio\" name=\"product\" value=\"poster\" checked=\"true\" /> Poster <br />
<input type=\"radio\" name=\"product\" value=\"book/magazine\" disabled=\"disabled\" /> Book/Magazine <br />
<input type=\"radio\" name=\"product\" value=\"card\" disabled=\"disabled\" /> Card <br/>
<input type=\"radio\" name=\"product\" value=\"newspaper\" disabled=\"disabled\" /> Newspaper <br />
</fieldset>
<input type=\"submit\" name=\"product\" value=\"Submit\">
</form>
</div>
";
    }

    public function getTemplateName()
    {
        return "LobamaSocial2PrintBundle:Default:product.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
