function bb_parse55(string_bbcode) {
  console.log(string_bbcode);
    let tags = 'b|u|i|ul|li|size|color|center|quote|url|img';
    let tag = 'b';
    let matches = string_bbcode.match(/\[((.+).*)=?(.*?)\](.*?)\[\/\1\]/g);
    console.log(matches);
    matches.forEach(element => {
        
    });
    /*while ((matches = string.match('`\[('+tags+')=?(.*?)\](.+?)\[/\1\]`')) != undefined).foreach (matches[0] as key => match) {
      let tag = matches[1][key];
      let param = matches[2][$key];
      let innertext = matches[3][$key];
      let replacement = "";
      switch (tag) {
        case 'b': 
          replacement = "<strong>"+innertext+"</strong>";
          break;
        case 'u': 
          replacement = "<span style=\"text-decoration: underline\">"+innertext+"</span>"; 
          break;
        case 'ul': 
            replacement = "<ul>"+innertext+"</ul>"; 
            break;
        case 'li': 
            replacement = "<li>"+innertext+"</li>"; 
            break;
        case 'i': 
          replacement = "<em>"+innertext+"</em>";
          break;
        case 'size': 
          replacement = "<font style=\"font-size: "+param+"\">"+innertext</font>";
          break;
        case 'color': 
          replacement = "<font color=\""+param+"\">"+innertext</font>";
          break;
        case 'center': 
          replacement = "<div align=\"center\">"+innertext</div>";
          break;
        case 'quote': 
          $replacement = "<blockquote>"+innertext+"</blockquote>" + ((param.trim() != "") ? "<cite>"+param+"</cite>" : '');
          break;
        case 'url': 
          replacement = '<a href="' + (param.trim() != "" ? param : innertext) + "\">"+innertext+"</a>";
          break;
        / *case 'img':
          list($width, $height) = preg_split('`[Xx]`', param);
          $replacement = "<img src=\"$innertext\" " + (is_numeric(width)? "width=\"$width\" " : '') + (is_numeric(height)? "height=\"$height\" " : '') . '/>';
        break;
        case 'video':
          $videourl = parse_url($innertext);
          parse_str($videourl['query'], $videoquery);
          if (strpos($videourl['host'], 'youtube.com') !== FALSE) $replacement = '<embed src="http://www.youtube.com/v/' . $videoquery['v'] . '" type="application/x-shockwave-flash" width="425" height="344"></embed>';
          if (strpos($videourl['host'], 'google.com') !== FALSE) $replacement = '<embed src="http://video.google.com/googleplayer.swf?docid=' . $videoquery['docid'] . '" width="400" height="326" type="application/x-shockwave-flash"></embed>';
        break;* /
      }
      $string = str_replace($match, $replacement, $string);
    }*/
    return string_bbcode;
}


document.getElementById("btn-test-58").addEventListener("click", function(e) {
  document.querySelectorAll(".editor_bbcode").forEach(element => {
    console.log("0001");
    console.log(element);
    bb_parse55(element.value);
  });
})