<?php

/* ::base.html.twig */
class __TwigTemplate_871e358f6d90b247ae049f42fa2e83c1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'breadcrumbs' => array($this, 'block_breadcrumbs'),
            'body' => array($this, 'block_body'),
            'footer' => array($this, 'block_footer'),
            'javascripts' => array($this, 'block_javascripts'),
            'debug' => array($this, 'block_debug'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class=\"no-js ie6 oldie\" lang=\"en\"> <![endif]-->
<!--[if IE 7]>    <html class=\"no-js ie7 oldie\" lang=\"en\"> <![endif]-->
<!--[if IE 8]>    <html class=\"no-js ie8 oldie\" lang=\"en\"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html lang=\"en\"> <!--<![endif]-->
<head>
        <head>
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                <title>";
        // line 11
        $this->displayBlock('title', $context, $blocks);
        echo "</title>

                 ";
        // line 13
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 17
        echo "        <link rel=\"shortcut icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        </head>

        <body>
                <div id=\"container\">
                        <div id=\"main\" role=\"main\">
                                <div class=\"header\">
                    <div class=\"logo-container\"><span class=\"logo\"></span></div>
                    ";
        // line 25
        $this->displayBlock('breadcrumbs', $context, $blocks);
        // line 26
        echo "                </div>

                                ";
        // line 28
        $this->displayBlock('body', $context, $blocks);
        // line 29
        echo "
                                <!-- Main Layout : footer -->
\t\t\t\t";
        // line 31
        $this->displayBlock('footer', $context, $blocks);
        // line 39
        echo "                                <!-- Main Layout : footer -->

                        </div>
                </div>
        ";
        // line 43
        $this->displayBlock('javascripts', $context, $blocks);
        // line 45
        echo "        ";
        if (($this->getAttribute($this->getContext($context, "app"), "environment") == "dev")) {
            // line 46
            echo "        ";
            if (array_key_exists("debug", $context)) {
                // line 47
                echo "        ";
                $this->displayBlock('debug', $context, $blocks);
                // line 57
                echo "        ";
            }
            // line 58
            echo "        ";
        }
        // line 59
        echo "        </body>
</html>
";
    }

    // line 11
    public function block_title($context, array $blocks = array())
    {
        echo "Your Facebook Poster - Social2Print";
    }

    // line 13
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 14
        echo "                                <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/lobamasocial2print/styles/debug/base.css"), "html", null, true);
        echo "\">
                <link rel=\"stylesheet\" href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/lobamasocial2print/styles/debug/s2pPoster.css"), "html", null, true);
        echo "\">
                 ";
    }

    // line 25
    public function block_breadcrumbs($context, array $blocks = array())
    {
    }

    // line 28
    public function block_body($context, array $blocks = array())
    {
    }

    // line 31
    public function block_footer($context, array $blocks = array())
    {
        // line 32
        echo "                                <div class=\"footer\">
                                        <ul class=\"links\">
                                                <li class=\"back\"><a href=\"http://facebook.com/social2print\" target=\"_top\">";
        // line 34
        echo $this->env->getExtension('translator')->getTranslator()->trans("Return to Fanpage", array(), "messages");
        echo "</a></li>
                                                <li class=\"back\"><a href=\"";
        // line 35
        echo twig_escape_filter($this->env, $this->getContext($context, "logout_url"), "html", null, true);
        echo "\" target=\"_top\">";
        echo $this->env->getExtension('translator')->getTranslator()->trans("Logout", array(), "messages");
        echo "</a></li>
                                        </ul>
                                </div>
                                ";
    }

    // line 43
    public function block_javascripts($context, array $blocks = array())
    {
        // line 44
        echo "        ";
    }

    // line 47
    public function block_debug($context, array $blocks = array())
    {
        // line 48
        echo "                <table>
                ";
        // line 49
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, "debug"));
        foreach ($context['_seq'] as $context["key"] => $context["debug_item"]) {
            // line 50
            echo "                        <tr>
                                <td><strong>";
            // line 51
            echo twig_escape_filter($this->env, $this->getContext($context, "key"), "html", null, true);
            echo "</strong></td>
        <td>";
            // line 52
            echo $this->getContext($context, "debug_item");
            echo "</td>
                        </tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['debug_item'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 55
        echo "                <table>
        ";
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
