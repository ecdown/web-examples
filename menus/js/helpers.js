
        function getCount(parent, getChildrensChildren) {
            var relevantChildren = 0;
            var children = parent.childNodes.length;

            for (var i = 0; i < children; i++) {
                
                if (parent.childNodes[i].nodeType != 3) {
                if (getChildrensChildren) {
                    relevantChildren += getCount(parent.childNodes[i], true);
                }
                relevantChildren++;
                }
            }
            return relevantChildren;
        }
