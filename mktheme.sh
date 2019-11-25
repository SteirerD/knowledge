#!/bin/sh
# Sunlime Web Innovations GmbH
# http://www.sunlime.at/

NAME="wiki"
SLUG="wiki"
DESC="Wiki"

##########################

find theme -name '*.php' -type f -exec sed -i '' -e "s/SUNLIME_NAME/$NAME/g" {} +
find theme -name '*.php' -type f -exec sed -i '' -e "s/sunlime_slug/$SLUG/g" {} +
find theme -name '*.php' -type f -exec sed -i '' -e "s/SUNLIME_DESC/$DESC/g" {} +

find theme -name '*.css' -type f -exec sed -i '' -e "s/SUNLIME_NAME/$NAME/g" {} +
find theme -name '*.css' -type f -exec sed -i '' -e "s/sunlime_slug/$SLUG/g" {} +
find theme -name '*.css' -type f -exec sed -i '' -e "s/SUNLIME_DESC/$DESC/g" {} +

find theme -name '*.txt' -type f -exec sed -i '' -e "s/SUNLIME_NAME/$NAME/g" {} +
find theme -name '*.txt' -type f -exec sed -i '' -e "s/sunlime_slug/$SLUG/g" {} +
find theme -name '*.txt' -type f -exec sed -i '' -e "s/SUNLIME_DESC/$DESC/g" {} +

find source -name '*.scss' -type f -exec sed -i '' -e "s/SUNLIME_NAME/$NAME/g" {} +
find source -name '*.scss' -type f -exec sed -i '' -e "s/sunlime_slug/$SLUG/g" {} +
find source -name '*.scss' -type f -exec sed -i '' -e "s/SUNLIME_DESC/$DESC/g" {} +
