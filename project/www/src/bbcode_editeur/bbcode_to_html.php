<?php
function bb_parse($string) {
    $tags = 'b|u|i|ul|li|size|color|center|quote|url|img';
    while (preg_match_all('`\[('.$tags.')=?(.*?)\](.+?)\[/\1\]`', $string, $matches)) foreach ($matches[0] as $key => $match) {
      list($tag, $param, $innertext) = array($matches[1][$key], $matches[2][$key], $matches[3][$key]);
      switch ($tag) {
        case 'b': 
          $replacement = "<strong>$innertext</strong>";
          break;
        case 'u': 
          $replacement = "<span style=\"text-decoration: underline\">$innertext</span>"; 
          break;
        case 'ul': 
            $replacement = "<ul>$innertext</ul>"; 
            break;
        case 'li': 
            $replacement = "<li>$innertext</li>"; 
            break;
        case 'i': 
          $replacement = "<em>$innertext</em>";
          break;
        case 'size': 
          $replacement = "<font style=\"font-size: $param\">$innertext</font>";
          break;
        case 'color': 
          $replacement = "<font color=\"$param\">$innertext</font>";
          break;
        case 'center': 
          $replacement = "<div align=\"center\">$innertext</div>";
          break;
        case 'quote': 
          $replacement = "<blockquote>$innertext</blockquote>" . $param? "<cite>$param</cite>" : '';
          break;
        case 'url': 
          $replacement = '<a href="' . ($param? $param : $innertext) . "\">$innertext</a>";
          break;
        case 'img':
          list($width, $height) = preg_split('`[Xx]`', $param);
          $replacement = "<img src=\"$innertext\" " . (is_numeric($width)? "width=\"$width\" " : '') . (is_numeric($height)? "height=\"$height\" " : '') . '/>';
        break;
        case 'video':
          $videourl = parse_url($innertext);
          parse_str($videourl['query'], $videoquery);
          if (strpos($videourl['host'], 'youtube.com') !== FALSE) $replacement = '<embed src="http://www.youtube.com/v/' . $videoquery['v'] . '" type="application/x-shockwave-flash" width="425" height="344"></embed>';
          if (strpos($videourl['host'], 'google.com') !== FALSE) $replacement = '<embed src="http://video.google.com/googleplayer.swf?docid=' . $videoquery['docid'] . '" width="400" height="326" type="application/x-shockwave-flash"></embed>';
        break;
      }
      $string = str_replace($match, $replacement, $string);
    }
    return $string;
}

function recup_bbcode($string) {
  $bbcode_html = "";
  $values_line = explode("\n", $string);
  foreach ($values_line as $value) {
    if(empty(trim($value))) {
      $bbcode_html .= "<div><br></div>"."\n";
    } else {
      $bbcode_html .= "<div>".bb_parse($value)."</div>"."\n";
    }
  }
  return $bbcode_html;
}

/*b = {
    b: {
      tags: { b: null, strong: null },
      styles: {
        "font-weight": ["bold", "bolder", "401", "700", "800", "900"],
      },
      format: "[b]{0}[/b]",
      html: "<strong>{0}</strong>",
    },
    i: {
      tags: { i: null, em: null },
      styles: { "font-style": ["italic", "oblique"] },
      format: "[i]{0}[/i]",
      html: "<em>{0}</em>",
    },
    u: {
      tags: { u: null },
      styles: { "text-decoration": ["underline"] },
      format: "[u]{0}[/u]",
      html: "<u>{0}</u>",
    },
    s: {
      tags: { s: null, strike: null },
      styles: { "text-decoration": ["line-through"] },
      format: "[s]{0}[/s]",
      html: "<s>{0}</s>",
    },
    sub: {
      tags: { sub: null },
      format: "[sub]{0}[/sub]",
      html: "<sub>{0}</sub>",
    },
    sup: {
      tags: { sup: null },
      format: "[sup]{0}[/sup]",
      html: "<sup>{0}</sup>",
    },
    font: {
      tags: { font: { face: null } },
      styles: { "font-family": null },
      quoteType: y.never,
      format: function (e, t) {
        var n
        return (
          "[font=" +
          k(
            (n =
              !h(e, "font") || !(n = m(e, "face"))
                ? p(e, "font-family")
                : n)
          ) +
          "]" +
          t +
          "[/font]"
        )
      },
      html: '<font face="{defaultattr}">{0}</font>',
    },
    size: {
      tags: { font: { size: null } },
      styles: { "font-size": null },
      format: function (e, t) {
        var n = m(e, "size"),
          r = 2
        return (
          -1 < (n = n || p(e, "fontSize")).indexOf("px")
            ? ((n = +n.replace("px", "")) < 12 && (r = 1),
              15 < n && (r = 3),
              17 < n && (r = 4),
              23 < n && (r = 5),
              31 < n && (r = 6),
              47 < n && (r = 7))
            : (r = n),
          "[size=" + r + "]" + t + "[/size]"
        )
      },
      html: '<font size="{defaultattr}">{!0}</font>',
    },
    color: {
      tags: { font: { color: null } },
      styles: { color: null },
      quoteType: y.never,
      format: function (e, t) {
        var n
        return (
          "[color=" +
          s(
            (n =
              !h(e, "font") || !(n = m(e, "color"))
                ? e.style.color || p(e, "color")
                : n)
          ) +
          "]" +
          t +
          "[/color]"
        )
      },
      html: function (e, t, n) {
        return (
          '<font color="' + d(s(t.defaultattr), !0) + '">' + n + "</font>"
        )
      },
    },
    ul: {
      tags: { ul: null },
      breakStart: !0,
      isInline: !1,
      skipLastLineBreak: !0,
      format: "[ul]{0}[/ul]",
      html: "<ul>{0}</ul>",
    },
    list: {
      breakStart: !0,
      isInline: !1,
      skipLastLineBreak: !0,
      html: "<ul>{0}</ul>",
    },
    ol: {
      tags: { ol: null },
      breakStart: !0,
      isInline: !1,
      skipLastLineBreak: !0,
      format: "[ol]{0}[/ol]",
      html: "<ol>{0}</ol>",
    },
    li: {
      tags: { li: null },
      isInline: !1,
      closedBy: ["/ul", "/ol", "/list", "*", "li"],
      format: "[li]{0}[/li]",
      html: "<li>{0}</li>",
    },
    "*": {
      isInline: !1,
      closedBy: ["/ul", "/ol", "/list", "*", "li"],
      html: "<li>{0}</li>",
    },
    table: {
      tags: { table: null },
      isInline: !1,
      isHtmlInline: !0,
      skipLastLineBreak: !0,
      format: "[table]{0}[/table]",
      html: "<table>{0}</table>",
    },
    tr: {
      tags: { tr: null },
      isInline: !1,
      skipLastLineBreak: !0,
      format: "[tr]{0}[/tr]",
      html: "<tr>{0}</tr>",
    },
    th: {
      tags: { th: null },
      allowsEmpty: !0,
      isInline: !1,
      format: "[th]{0}[/th]",
      html: "<th>{0}</th>",
    },
    td: {
      tags: { td: null },
      allowsEmpty: !0,
      isInline: !1,
      format: "[td]{0}[/td]",
      html: "<td>{0}</td>",
    },
    emoticon: {
      allowsEmpty: !0,
      tags: { img: { src: null, "data-sceditor-emoticon": null } },
      format: function (e, t) {
        return m(e, v) + t
      },
      html: "{0}",
    },
    hr: {
      tags: { hr: null },
      allowsEmpty: !0,
      isSelfClosing: !0,
      isInline: !1,
      format: "[hr]{0}",
      html: "<hr />",
    },
    img: {
      allowsEmpty: !0,
      tags: { img: { src: null } },
      allowedChildren: ["#"],
      quoteType: y.never,
      format: function (t, e) {
        var n = "",
          r = function (e) {
            return t.style ? t.style[e] : null
          }
        return m(t, v)
          ? e
          : ((e = m(t, "width") || r("width")),
            (r = m(t, "height") || r("height")),
            "[img" +
              (n =
                (t.complete && (e || r)) || (e && r)
                  ? "=" + f.width(t) + "x" + f.height(t)
                  : n) +
              "]" +
              m(t, "src") +
              "[/img]")
      },
      html: function (e, t, n) {
        var r = "",
          o = t.width,
          i = t.height
        return (
          t.defaultattr &&
            ((o = (t = t.defaultattr.split(/x/i))[0]),
            (i = 2 === t.length ? t[1] : t[0])),
          void 0 !== o && (r += ' width="' + d(o, !0) + '"'),
          void 0 !== i && (r += ' height="' + d(i, !0) + '"'),
          "<img" + r + ' src="' + a(n) + '" />'
        )
      },
    },
    url: {
      allowsEmpty: !0,
      tags: { a: { href: null } },
      quoteType: y.never,
      format: function (e, t) {
        e = m(e, "href")
        return "mailto:" === e.substr(0, 7)
          ? '[email="' + e.substr(7) + '"]' + t + "[/email]"
          : "[url=" + e + "]" + t + "[/url]"
      },
      html: function (e, t, n) {
        return (
          (t.defaultattr = d(t.defaultattr, !0) || n),
          '<a href="' + a(t.defaultattr) + '">' + n + "</a>"
        )
      },
    },
    email: {
      quoteType: y.never,
      html: function (e, t, n) {
        return (
          '<a href="mailto:' +
          (d(t.defaultattr, !0) || n) +
          '">' +
          n +
          "</a>"
        )
      },
    },
    quote: {
      tags: { blockquote: null },
      isInline: !1,
      quoteType: y.never,
      format: function (e, t) {
        for (
          var n, r = "data-author", o = "", i = e.children, a = 0
          !n && a < i.length
          a++
        )
          h(i[a], "cite") && (n = i[a])
        return (
          (n || m(e, r)) &&
            ((o = (n && n.textContent) || m(e, r)),
            m(e, r, o),
            n && e.removeChild(n),
            (t = this.elementToBbcode(e)),
            (o = "=" + o.replace(/(^\s+|\s+$)/g, "")),
            n && e.insertBefore(n, e.firstChild)),
          "[quote" + o + "]" + t + "[/quote]"
        )
      },
      html: function (e, t, n) {
        return (
          "<blockquote>" +
          (n = t.defaultattr
            ? "<cite>" + d(t.defaultattr) + "</cite>" + n
            : n) +
          "</blockquote>"
        )
      },
    },
    code: {
      tags: { code: null },
      isInline: !1,
      allowedChildren: ["#", "#newline"],
      format: "[code]{0}[/code]",
      html: "<code>{0}</code>",
    },
    left: {
      styles: {
        "text-align": ["left", "-webkit-left", "-moz-left", "-khtml-left"],
      },
      isInline: !1,
      allowsEmpty: !0,
      format: "[left]{0}[/left]",
      html: '<div align="left">{0}</div>',
    },
    center: {
      styles: {
        "text-align": [
          "center",
          "-webkit-center",
          "-moz-center",
          "-khtml-center",
        ],
      },
      isInline: !1,
      allowsEmpty: !0,
      format: "[center]{0}[/center]",
      html: '<div align="center">{0}</div>',
    },
    right: {
      styles: {
        "text-align": [
          "right",
          "-webkit-right",
          "-moz-right",
          "-khtml-right",
        ],
      },
      isInline: !1,
      allowsEmpty: !0,
      format: "[right]{0}[/right]",
      html: '<div align="right">{0}</div>',
    },
    justify: {
      styles: {
        "text-align": [
          "justify",
          "-webkit-justify",
          "-moz-justify",
          "-khtml-justify",
        ],
      },
      isInline: !1,
      allowsEmpty: !0,
      format: "[justify]{0}[/justify]",
      html: '<div align="justify">{0}</div>',
    },
    youtube: {
      allowsEmpty: !0,
      tags: { iframe: { "data-youtube-id": null } },
      format: function (e, t) {
        return (e = m(e, "data-youtube-id"))
          ? "[youtube]" + e + "[/youtube]"
          : t
      },
      html:
        '<iframe width="560" height="315" frameborder="0" src="https://www.youtube-nocookie.com/embed/{0}?wmode=opaque" data-youtube-id="{0}" allowfullscreen></iframe>',
    },
    rtl: {
      styles: { direction: ["rtl"] },
      isInline: !1,
      format: "[rtl]{0}[/rtl]",
      html: '<div style="direction: rtl">{0}</div>',
    },
    ltr: {
      styles: { direction: ["ltr"] },
      isInline: !1,
      format: "[ltr]{0}[/ltr]",
      html: '<div style="direction: ltr">{0}</div>',
    },
    ignore: {},
  }*/