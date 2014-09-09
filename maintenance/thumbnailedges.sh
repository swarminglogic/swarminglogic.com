#!/bin/bash

# convert $1 -alpha set -virtual-pixel transparent \
#     -channel A -blur 0x1  -level 50%,100% +channel $2

# # mask=$(tempfile --suffix=".png")
mask="/tmp/mask.png"
convert $1 -alpha off -fill white -colorize 100% \
     -draw 'fill black polygon 0,0 0,6 6,0 fill white circle 6,6 6,0' \
     \( +clone -flip \) -compose Multiply -composite \
     \( +clone -flop \) -compose Multiply -composite \
     -background gray70 -alpha Shape $mask

# #light=$(tempfile --suffix=".png")
light="/tmp/light.png"
convert $mask -bordercolor None -border 1x1 \
    -alpha Extract -blur 0x9 -shade 60x47 -alpha On \
          -background Gray10 -alpha background -auto-level \
          -function polynomial  3.5,-5.05,2.05,0.3 \
          \( +clone -alpha extract  -blur 1x1 \) \
          -channel RGB -compose multiply -composite \
          +channel +compose -chop 1x1 \
          $light

lightb="/tmp/light-bright.png"
convert $light -level 5%,110%,1.8 -fill \#11111111 -tint 100 $lightb

    # -alpha Extract -blur 0x10  -shade 130x37 -alpha On \
          # -function polynomial  3.5,-5.05,2.05,0.3 \



convert $1 -alpha Set $lightb \
          \( -clone 0,1 -alpha Opaque -compose Hardlight -composite \) \
          -delete 0 -compose In -composite \
          $2

#echo "mask: $mask"
echo "light: $light"
# rm $mask
# rm $mask $light
