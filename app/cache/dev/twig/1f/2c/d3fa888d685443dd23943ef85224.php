<?php

/* LobamaSocial2PrintBundle:Default:index_backup.html.twig */
class __TwigTemplate_1f2cd3fa888d685443dd23943ef85224 extends Twig_Template
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
";
        // line 10
        if (($this->getContext($context, "name") && $this->getContext($context, "logout_url"))) {
            // line 11
            echo "Hello ";
            echo twig_escape_filter($this->env, $this->getContext($context, "name"), "html", null, true);
            echo "!

<a href=\"";
            // line 13
            echo twig_escape_filter($this->env, $this->getContext($context, "logout_url"), "html", null, true);
            echo "\">Logout</a><br />
";
        }
        // line 15
        echo "<div class=\"poster\"></div>
</body>
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
        return "LobamaSocial2PrintBundle:Default:index_backup.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
