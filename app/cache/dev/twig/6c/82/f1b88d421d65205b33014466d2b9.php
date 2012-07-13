<?php

/* LobamaSocial2PrintBundle:Default:index.html.twig */
class __TwigTemplate_6c82f1b88d421d65205b33014466d2b9 extends Twig_Template
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
        echo "<div class=\"content landing\">
    <div class=\"inner\">
        <div class=\"poster\">
            <img src=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/lobamasocial2print/gfx/landing.poster.png"), "html", null, true);
        echo "\" alt=\"\">
        </div>
        <div id=\"welcome\">
            <h1>";
        // line 10
        echo $this->env->getExtension('translator')->getTranslator()->trans("Your Facebook Poster", array(), "messages");
        echo "</h1>
            <div id=\"arrow-bottom\">&nbsp;</div>
            <div class=\"teaser-text\">
                <p>";
        // line 13
        echo $this->env->getExtension('translator')->getTranslator()->trans("How it works", array(), "messages");
        echo ":</p>
                <ol>
\t\t    <li>";
        // line 15
        echo $this->env->getExtension('translator')->getTranslator()->trans("Choose your options.", array(), "messages");
        echo "</li>
                    <li>";
        // line 16
        echo $this->env->getExtension('translator')->getTranslator()->trans("Modify the preview or press next.", array(), "messages");
        echo "</li>
                    <li>";
        // line 17
        echo $this->env->getExtension('translator')->getTranslator()->trans("Select your poster size.", array(), "messages");
        echo "</li>
                </ol>
            </div>
            <div class=\"continue\">
                <a href=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_product"), "html", null, true);
        echo "\" class=\"button\">";
        echo $this->env->getExtension('translator')->getTranslator()->trans("Generate poster now", array(), "messages");
        echo "</a>
            </div>
            <div class=\"clearfix\"></div>
        </div>
    </div>
    <div class=\"clearfix\"></div>
</div>
";
    }

    public function getTemplateName()
    {
        return "LobamaSocial2PrintBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
