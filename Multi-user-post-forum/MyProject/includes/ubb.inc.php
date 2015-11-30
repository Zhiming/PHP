<?php

//Protect from illegal access
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

?>

<div id="ubb">
					<img src="images/fontsize.gif" title="font size" alt="font size" />
					<img src="images/space.gif" title="line" alt="line" />
					<img src="images/bold.gif" title="bold" alt="bold"/>
					<img src="images/italic.gif" title="italic"alt="italic" />
					<img src="images/underline.gif" title="underline"alt="underline" />
					<img src="images/strikethrough.gif" title="strikethrough"alt="strikethrough" />
					<img src="images/space.gif"title="space"alt="space" />
					<img src="images/color.gif" title="color"alt="color" />
					<img src="images/url.gif" title="URL"alt="URL" />
					<img src="images/email.gif" title="Email"alt="Email" />
					<img src="images/image.gif" title="Picture" alt="Picture"/>
					<img src="images/swf.gif" title="flash"alt="flash" />
					<img src="images/space.gif"/>
					<img src="images/increase.gif" title="Expand Type-in area"alt="Expand Type-in area" />
					<img src="images/decrease.gif" title="Reduce Type-in area"alt="Reduce Type-in area" />
				</div>
				<div id="font">
					<strong onclick="font(10)">10px</strong>
					<strong onclick="font(12)">12px</strong>
					<strong onclick="font(14)">14px</strong>
					<strong onclick="font(16)">16px</strong>
					<strong onclick="font(18)">18px</strong>
					<strong onclick="font(20)">20px</strong>
					<strong onclick="font(22)">22px</strong>
					<strong onclick="font(24)">24px</strong>
				</div>
				<div id="color">
					<strong title="black" style="background:#000" onclick="showcolor('#000')"></strong>
					<strong title="brown" style="background:#930" onclick="showcolor('#930')"></strong>
					<strong title="olive" style="background:#330" onclick="showcolor('#330')"></strong>
					<strong title="dark green" style="background:#030" onclick="showcolor('#030')"></strong>
					<strong title="darkcyan" style="background:#036" onclick="showcolor('#036')"></strong>
					<strong title="deongaree" style="background:#000080" onclick="showcolor('#000080')"></strong>
					<strong title="grey-80%" style="background:#333" onclick="showcolor('#333')"></strong>
					<strong title="crimson" style="background:#800000" onclick="showcolor('#800000')"></strong>
					<strong title="orange" style="background:#f60" onclick="showcolor('#f60')"></strong>
					<strong title="deep yellow" style="background:#808000" onclick="showcolor('#000')"></strong>
					<strong title="dark green" style="background:#008000" onclick="showcolor('#808000')"></strong>
					<strong title="green" style="background:#008080" onclick="showcolor('#008080')"></strong>
					<strong title="blue" style="background:#00f" onclick="showcolor('#00f')"></strong>
					<strong title="blue grey" style="background:#669" onclick="showcolor('#669')"></strong>
					<strong title="grey-50%" style="background:#808080" onclick="showcolor('#808080')"></strong>
					<strong title="red" style="background:#f00" onclick="showcolor('#f00')"></strong>
					<strong title="light orange" style="background:#f90" onclick="showcolor('#f90')"></strong>
					<strong title="lime" style="background:#9c0" onclick="showcolor('#9c0')"></strong>
					<strong title="Scarlet Pimpernel" style="background:#396" onclick="showcolor('#396')"></strong>
					<strong title="Aqua green" style="background:#3cc" onclick="showcolor('#3cc')"></strong>
					<strong title="light blue" style="background:#36f" onclick="showcolor('#36f')"></strong>
					<strong title="violet" style="background:#800080" onclick="showcolor('#800080')"></strong>
					<strong title="grey-40%" style="background:#999" onclick="showcolor('#999')"></strong>
					<strong title="pink" style="background:#f0f" onclick="showcolor('#f0f')"></strong>
					<strong title="golden" style="background:#fc0" onclick="showcolor('#fc0')"></strong>
					<strong title="yellow" style="background:#ff0" onclick="showcolor('#ff0')"></strong>
					<strong title="viridity" style="background:#0f0" onclick="showcolor('#0f0')"></strong>
					<strong title="azure" style="background:#0cf" onclick="showcolor('#0cf')"></strong>
					<strong title="plum" style="background:#936" onclick="showcolor('#936')"></strong>
					<strong title="grey-20%" style="background:#c0c0c0" onclick="showcolor('#c0c0c0')"></strong>
					<strong title="rose" style="background:#f90" onclick="showcolor('#f90')"></strong>
					<strong title="tawny" style="background:#fc9" onclick="showcolor('#fc9')"></strong>
					<strong title="pale yellow" style="background:#ff9" onclick="showcolor('#ff9')"></strong>
					<strong title="light green" style="background:#cfc" onclick="showcolor('#cfc')"></strong>
					<strong title="light cyan" style="background:#cff" onclick="showcolor('#cff')"></strong>
					<strong title="light blue" style="background:#9cf" onclick="showcolor('#9cf')"></strong>
					<strong title="pale purple" style="background:#c9f" onclick="showcolor('#c9f')"></strong>
					<strong title="white" style="background:#fff" ></strong>
					<em><input type="text" name="t" value="#" /></em>
				</div>