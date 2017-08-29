
        var posX = 0;
        var offset = 0;
        var widthOfItem = 546;
        var w = document.body.clientWidth;
        var block = document.getElementById('block');
        var horizontalMenu = document.getElementById("block");

        var horizontalMenuItems = getCount(horizontalMenu, false);
        var diff = (widthOfItem * horizontalMenuItems) - w;
        
        function map(n, start1, stop1, start2, stop2) {
            return((n - start1) / (stop1 - start1)) * (stop2 - start2) + start2;
        }
        
        function mover(e) {
            posX = e.clientX;
            offset = Math.floor(map(posX, 0, w , 0, diff));
            offset = offset - (offset * 2);
            block.style.transform = "translate(" + offset + "px)";
        }
