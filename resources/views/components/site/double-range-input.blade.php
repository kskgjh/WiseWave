<div id="doubleRangeInput" x-data="doubleRangeInput">

    <div x-ref="line" class="line" 
        @mousedown="handleDownClick($event.target)" 
        @mouseup="handleUpClick($event.target)"
        @mousemove="getMouseCoords($event)">
        <span class="maxValue"></span>
        <span class="minValue"></span>
    </div>

    <label for="min">Mínimo
        <span x-text="minValue"></span>
    </label>
    <label for="max">Máximo
        <span x-text="maxValue"></span>
    </label>

    <input type="hidden"  x-model='minValue'>
    <input type="hidden" x-model='maxValue'>

    {{-- <script>
        let line = document.querySelector('.line')
        var animation, xLine, min, max, target, startMouseX, mouseX, moveElement;

        function movePointer(){
            console.log('animando')

        }
        (function getCoords(){
            let lineCoords = line.getBoundingClientRect()
            console.log(lineCoords)

            xLine = lineCoords.top + 2;
            min = lineCoords.x;
            max = lineCoords.x + lineCoords.width;
            console.log(`min: ${min}, max: ${max}`);
        })();

        function getMousePosition(event){
            //console.log(event)
            mouseX = event.movementX
        }

        line.addEventListener('mousemove', e=> getMousePosition(e));

        line.addEventListener('mousedown', e=> { 
            if(e.target === line) return;
            target = e.target;
            moveElement = true;
            movePointer();
        })
        line.addEventListener('mouseleave', e=> { 
            moveElement = false;
        })
        line.addEventListener('mouseup', e=> { 
            moveElement = false;
        })


    </script> --}}
</div>