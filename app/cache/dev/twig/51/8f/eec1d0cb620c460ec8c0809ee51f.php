<?php

/* LobamaSocial2PrintBundle:PosterLayouts:gridPhoto54.yml.twig */
class __TwigTemplate_518feec1d0cb620c460ec8c0809ee51f extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["cols"] = 6;
        // line 2
        $context["rows"] = 9;
        // line 3
        echo "config:
  layoutName: gridPhoto54
  minPhotos: 54
  maxPhotos: ~
  visiblePhotos: 54
  size:
    cols: ";
        // line 9
        echo twig_escape_filter($this->env, $this->getContext($context, "cols"), "html", null, true);
        echo "
    rows: ";
        // line 10
        echo twig_escape_filter($this->env, $this->getContext($context, "rows"), "html", null, true);
        echo "
  styles:
    labelBox:
      stroke: # rgba (0-255, 0-255, 0-255, 0-1)
        r: 0
        g: 62
        b: 125
        a: 1
      fill: #rgba (0-255, 0-255, 0-255, 0-1)
        r: 0
        g: 62
        b: 125
        a: 1 
      lineWidthPt: 0.000001 #pt
      lineWidthPx: 0; #px
    labelTitle:
      font: YanoneKaffeesatz-Regular.ttf
      webfont: Yanone Kaffeesatz
      encoding: unicode
      fontsize: 84
      fill: #rgba
        r: 255
        g: 255
        b: 255
        a: 1
      marginh: 0.4
      marginv: 0.25
    labelSubTitle:
      font: YanoneKaffeesatz-Regular.ttf
      webfont: Yanone Kaffeesatz
      encoding: unicode
      fontsize: 48
      fill: #rgba
        r: 255
        g: 255
        b: 255
        a: 1
      marginh: 0.4
      marginv: 0.6
labels:
  -
    name: posterLabel
    coords: [3,5]
    dim: [3,1]
    style: labelBox
    textlines:
      -
        name: title
        style: labelTitle
        value: The Social2Print Poster # Example Data
      -
        name: subtitle
        style: labelSubTitle
        value: Max Mustermann # Example Data  
tiles:
";
        // line 65
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(range(0, ($this->getContext($context, "cols") - 1)));
        foreach ($context['_seq'] as $context["_key"] => $context["col"]) {
            // line 66
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable(range(0, ($this->getContext($context, "rows") - 1)));
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 67
                if ((!twig_in_filter($this->getContext($context, "col"), array(0 => 3, 1 => 4, 2 => 5)) || !twig_in_filter($this->getContext($context, "row"), array(0 => 5)))) {
                    // line 68
                    echo "  -
    type: photo
    coords: [";
                    // line 70
                    echo twig_escape_filter($this->env, $this->getContext($context, "col"), "html", null, true);
                    echo ",";
                    echo twig_escape_filter($this->env, $this->getContext($context, "row"), "html", null, true);
                    echo "]
    dim: [1,1]
";
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['col'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
    }

    public function getTemplateName()
    {
        return "LobamaSocial2PrintBundle:PosterLayouts:gridPhoto54.yml.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
