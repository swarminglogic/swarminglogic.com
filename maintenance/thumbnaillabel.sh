#!/bin/bash

tmpimage=$(tempfile --suffix=".png")
subtlemark $1 -b \#69BF -c \#021F -F 8 $tmpimage -t "$2" -p North -F 8
if [ $# -eq 3 ] ; then
    subtlemark $tmpimage -b \#BDBF -c \#021A -F 8 $tmpimage -t "$3" -p South -F 8
fi
/var/www/maintenance/thumbnailedges.sh $tmpimage thumbnail-soft.png
rm $tmpimage
