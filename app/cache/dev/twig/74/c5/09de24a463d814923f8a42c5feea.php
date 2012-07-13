<?php

/* LobamaSocial2PrintBundle:Default:indexpages.html.twig */
class __TwigTemplate_74c509de24a463d814923f8a42c5feea extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
<head>
<script>
</script>
";
        // line 5
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 8
        echo "</head>
<body>
Hello ";
        // line 10
        echo twig_escape_filter($this->env, $this->getContext($context, "name"), "html", null, true);
        echo "!
<a href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->getContext($context, "logout_url"), "html", null, true);
        echo "\">Logout</a><br />
";
        // line 12
        if ((($this->getContext($context, "page") - 1) > 1)) {
            // line 13
            echo "<a class=\"prev\" href=\"http://www.lobama.com/Symfony/web/app_dev.php?page=";
            echo twig_escape_filter($this->env, ($this->getContext($context, "page") - 2), "html", null, true);
            echo "\"><<</a>
";
        }
        // line 15
        if (($this->getContext($context, "iter") == 19)) {
            // line 16
            echo "<a class=\"next\" href=\"http://www.lobama.com/Symfony/web/app_dev.php?page=";
            echo twig_escape_filter($this->env, $this->getContext($context, "page"), "html", null, true);
            echo "\">>></a>
";
        }
        // line 18
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(range(0, $this->getContext($context, "iter")));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 19
            echo "<div class=\"img";
            echo twig_escape_filter($this->env, $this->getContext($context, "i"), "html", null, true);
            echo "\">
<img src=\"";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "photos"), $this->getContext($context, "i"), array(), "array"), "src", array(), "array"), "html", null, true);
            echo "\" /><br />
Likes ";
            // line 21
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "photos"), $this->getContext($context, "i"), array(), "array"), "likes", array(), "array"), "html", null, true);
            echo "<br />
Comments ";
            // line 22
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "photos"), $this->getContext($context, "i"), array(), "array"), "comments", array(), "array"), "html", null, true);
            echo "
</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 25
        echo "</body>
</html>
";
    }

    // line 5
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 6
        echo "\t<link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/lobamasocial2print/styles/debug/base.css"), "html", null, true);
        echo "\">
";
    }

    public function getTemplateName()
    {
        return "LobamaSocial2PrintBundle:Default:indexpages.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
