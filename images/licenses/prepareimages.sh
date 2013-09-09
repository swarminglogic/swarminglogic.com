#!/bin/bash

rm *.png
wget http://mirrors.creativecommons.org/presskit/buttons/80x15/png/{cc-zero,by{,-{nd,sa,nc{-sa,-nd}}}}.png
mv cc-zero.png zero.png

resize=50
alpha=40

for i in `ls *.png` ; do
    echo $i
    b=`echo $i | sed 's/\.png//g'`
    convert $i -resize $resize% -alpha set -channel Alpha -evaluate set $alpha% $b-flat.png.large
    pngcrush $b-flat.png.large $b-flat.png
    rm $b-flat.png.large
    rm $i
done
