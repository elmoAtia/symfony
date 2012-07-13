<?php

/* LobamaSocial2PrintBundle:Default:preview.html.twig */
class __TwigTemplate_28f88d1cf606860918ea21417b7e6afc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'breadcrumbs' => array($this, 'block_breadcrumbs'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
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
    public function block_breadcrumbs($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->env->loadTemplate("LobamaSocial2PrintBundle:Default:breadcrumbs.html.twig")->display(array_merge($context, array("current" => "preview")));
    }

    // line 9
    public function block_body($context, array $blocks = array())
    {
        // line 10
        echo "<div class=\"content preview\">
    <div id=\"posterPreview\"></div>
    <div class=\"inner\">
        <h1>Your Poster</h1>
        <p class=\"teaser-text\"></p>
        ";
        // line 38
        echo "        <div class=\"continue\"><a href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_checkout"), "html", null, true);
        echo "\" class=\"button\">Next<span></span></a></div>
        <div class=\"clearfix\"></div>
    </div>  
    <div class=\"clearfix\"></div>
</div>
";
    }

    // line 46
    public function block_javascripts($context, array $blocks = array())
    {
        // line 47
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/lobamaposter/scripts/debug/libs/yepnope.min.js"), "html", null, true);
        echo "\"></script>
<!--
-    Load custom scripts
-    Learn more about yepnope resources Loader: http://yepnopejs.com/
-->
<script> 
yepnope([{
load: '//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',
complete: function () { !window.jQuery ? yepnope('";
        // line 55
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/lobamaposter/scripts/debug/libs/jquery-1.7.min.js"), "html", null, true);
        echo "') : null }
}, {
load: '";
        // line 57
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/lobamaposter/scripts/debug/s2p.js"), "html", null, true);
        echo "',
complete: function () {
  
// var jsonPath = '../testData/json/new_json.json';  
// jQuery.getJSON(jsonPath, function(data) {
//var posterData = data;

        var posterData  = ";
        // line 64
        echo $this->getContext($context, "json");
        echo ";
        s2p.init('POSTER_PREVIEW', {
            container           : '#container',
            baseURI             : '";
        // line 67
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_service"), "html", null, true);
        echo "',
            assetBaseURL        : '../bundles/lobamaposter/',
            dir                 : 'debug/',
            previewPageURL      : '";
        // line 70
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_preview"), "html", null, true);
        echo "',
            getProgressURL      : '";
        // line 71
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_loading_progress"), "html", null, true);
        echo "',
            getCollectURL       : '";
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_create_poster"), "html", null, true);
        echo "',
            fadeTime            : 440,
            version             : '0.9.6'
        }, posterData);
  
}
}]);
</script>
";
    }

    public function getTemplateName()
    {
        return "LobamaSocial2PrintBundle:Default:preview.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
