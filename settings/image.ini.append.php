<?php /*


[ImageMagick]
Filters[]=centerimg=-gravity center -crop %1x%2+0+0 +repage
Filters[]=play_watermark=extension/ocmediaplayer/design/standard/images/play.png -composite -gravity center

[AliasSettings]
AliasList[]=video_splash

[video_splash]
Filters[]
Filters[]=geometry/scalewidth=600
Filters[]=centerimg=600;400
Filters[]=play_watermark



*/ ?>
