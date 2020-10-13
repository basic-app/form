<?php

use BasicApp\HtmlHelper\HtmlHelper;

echo HtmlHelper::tag($labelTag, $label, $labelAttributes);

echo $content;

echo HtmlHelper::tag($hintTag, $hint, $hintAttributes);

echo HtmlHelper::tag($errorTag, $error, $errorAttributes);