#!/bin/bash

cd "${0%/*}"

for f in img/tutorial-original/*.png; do
	file="$(basename "$f")"
	if [[ "img/tutorial/$file" -ot "$f" ]]; then
		echo "Shrinking/crushing $file"
		tmp=$(mktemp)
		convert "$f" -colorspace RGB -resize 900 -colorspace sRGB "$tmp"
		pngcrush "$tmp" "img/tutorial/$file"
		rm "$tmp"
	fi
done
