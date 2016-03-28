'use strict';
var _createClass = function () {
    function defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            // if (window.CP.shouldStopExecution(1)) {
            //     break;
            // }
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ('value' in descriptor)
                descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
        }
        // window.CP.exitedLoop(1);
    }
    return function (Constructor, protoProps, staticProps) {
        if (protoProps)
            defineProperties(Constructor.prototype, protoProps);
        if (staticProps)
            defineProperties(Constructor, staticProps);
        return Constructor;
    };
}();
function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
        throw new TypeError('Cannot call a class as a function');
    }
}
console.clear();
var log = console.log.bind(console);
var body = $('body')[0];
var ease = Back.easeOut.config(0.5);
var tiles = [];
var zones = [];
var zoneData = [
    {
        id: 'zone-1',
        grid: true,
        color: '#C71585',
        threshold: '60%',
        sortProp: 'imageId'
    },
    {
        id: 'zone-3',
        grid: false,
        color: '#6495ED',
        threshold: '100%',
        sortProp: null
    }
];
var tileData = [
    'x',
    'y',
    'imageId',
    'name'
];
var DropZone = function () {
    function DropZone(config) {
        var _this = this;
        _classCallCheck(this, DropZone);
        $.extend(this, config);
        this.tiles = [];
        this.element = $('#' + this.id)[0];
        this.parent = this.element.parentNode;
        $('#' + this.id + ' .tile').toArray().forEach(function (element) {
            return _this.initTile(element);
        });
        TweenLite.set(this.element, { autoAlpha: 1 });
    }
    DropZone.prototype.initTile = function initTile(element) {
        var config = tileData.reduce(function (tile, prop) {
            var value = element.dataset[prop];
            var number = parseFloat(value);
            tile[prop] = isNaN(number) ? value : number;
            return tile;
        }, {});
        var tile = new Tile(element, this, config);
    };
    DropZone.prototype.addTile = function addTile(tile) {
        var index = this.tiles.indexOf(tile);
        if (index > -1)
            return;
        this.tiles.push(tile);
        this.element.appendChild(tile.element);
        this.updateTiles();
        tile.updatePosition(this.grid);
        this.layoutTiles();
    };
    DropZone.prototype.removeTile = function removeTile(tile) {
        var index = this.tiles.indexOf(tile);
        if (index < 0)
            return;
        this.tiles.splice(index, 1);
        this.element.removeChild(tile.element);
        this.updateTiles();
        this.layoutTiles();
    };
    DropZone.prototype.updateTiles = function updateTiles() {
        var _this2 = this;
        if (this.sortProp) {
            this.sortTiles();
            this.tiles.forEach(function (tile) {
                return _this2.element.appendChild(tile.element);
            });
        }
    };
    DropZone.prototype.layoutTiles = function layoutTiles() {
        this.tiles.forEach(function (tile) {
            return tile.layout();
        });
    };
    DropZone.prototype.sortTiles = function sortTiles() {
        var _this3 = this;
        this.tiles.sort(function (left, right) {
            var a = left[_this3.sortProp];
            var b = right[_this3.sortProp];
            if (a !== b) {
                if (a > b || a === void 0)
                    return 1;
                if (a < b || b === void 0)
                    return -1;
            }
            return left.index - right.index;
        });
    };
    _createClass(DropZone, [
        {
            key: 'width',
            get: function get() {
                return this.element.offsetWidth;
            }
        },
        {
            key: 'height',
            get: function get() {
                return this.element.offsetHeight;
            }
        }
    ]);
    return DropZone;
}();
var Tile = function () {
    function Tile(element, zone, config) {
        _classCallCheck(this, Tile);
        this._x = 0;
        this._y = 0;
        this.xGrid = 0;
        this.yGrid = 0;
        this.xPercent = 0;
        this.yPercent = 0;
        this.element = element;
        this.clone = this.element.cloneNode(true);
        this.clone.classList.add('clone');
        this.zone = zone;
        this.lastZone = this.zone;
        this.isGrid = this.zone.grid;
        $.extend(this, config);
        this.transform = TweenLite.set(this.element, { x: '+=0' }).target._gsTransform;
        this.draggable = new Draggable(this.clone, {
            onDrag: this.onDrag,
            onRelease: this.stopDraggable,
            callbackScope: this
        }).disable();
        this.zone.addTile(this);
        $(this.element).on('mousedown touchstart', this.startDraggable.bind(this));
    }
    Tile.prototype.startDraggable = function startDraggable(event) {
        event.preventDefault();
        var position = getPosition(this.element);
        body.appendChild(this.clone);
        TweenLite.set(this.clone, {
            x: position.x,
            y: position.y,
            backgroundColor: "rgba(245,245,245, 0.8)",
        });
        TweenLite.set(this.element, {
            autoAlpha: 0,
            zIndex: Draggable.zIndex + 1
        });
        this.draggable.enable();
        this.draggable.update();
        this.draggable.startDrag(event);
    };
    Tile.prototype.stopDraggable = function stopDraggable(event) {
        var _this4 = this;
        this.draggable.disable();
        this.left = this.top = 0;
        var orphaned = zones.every(function (zone) {
            return !_this4.hitTest(zone);
        });
        if (orphaned && !this.isGrid) {
            this.left = this.xPercent;
            this.top = this.yPercent;
        }
        if (!this.zone) {
            this.zone = this.lastZone;
            zones.forEach(function (zone) {
                if (_this4.hitTest(zone))
                    _this4.zone = zone;
            });
        }
        this.zone.addTile(this);
        var offset = this.getOffset();
        var config = {
            backgroundColor: "none", //this.zone.color,
            boxShadow: "0px 0px 0px 0px rgba(0,255,0,0.3)",
            onComplete: function onComplete() {
                body.removeChild(_this4.clone);
                TweenLite.set(_this4.element, { autoAlpha: 1 });
            }
        };
        if (!this.isGrid && !orphaned) {
            this.x = offset.x;
            this.y = offset.y;
        } else {
            config.x = '-=' + offset.x;
            config.y = '-=' + offset.y;
            if (this.isGrid) {
                this.x = this.y = 0;
            }
        }
        TweenLite.to(this.clone, 0.3, config);
    };
    Tile.prototype.layout = function layout() {
        if (!this.isGrid)
            return;
        var lastX = this.gridX;
        var lastY = this.gridY;
        this.gridX = this.offsetX;
        this.gridY = this.offsetY;
        var dx = this.transform.x + lastX - this.gridX;
        var dy = this.transform.y + lastY - this.gridY;
        TweenLite.fromTo(this.element, 0.5, {
            x: dx,
            y: dy
        }, {
            x: 0,
            y: 0,
            ease: ease
        });
    };
    Tile.prototype.onDrag = function onDrag() {
        if (this.zone) {
            if (this.zone && !this.hitTest(this.zone, 0)) {
                this.lastZone = this.zone;
                this.zone.removeTile(this);
                this.zone = null;
            }
        }
    };
    Tile.prototype.getOffset = function getOffset() {
        var position1 = getPosition(this.clone);
        var position2 = getPosition(this.zone.element);
        return {
            x: position1.x - position2.x - this.offsetX,
            y: position1.y - position2.y - this.offsetY
        };
    };
    Tile.prototype.hitTest = function hitTest(zone, threshold) {
        var overlap = threshold != null ? threshold : zone.threshold;
        return Draggable.hitTest(this.clone, zone.parent, overlap);
    };
    Tile.prototype.updatePosition = function updatePosition(isGrid) {
        this.isGrid = isGrid;
        this.gridX = this.offsetX;
        this.gridY = this.offsetY;
    };
    _createClass(Tile, [
        {
            key: 'offsetX',
            get: function get() {
                return this.element.offsetLeft;
            }
        },
        {
            key: 'offsetY',
            get: function get() {
                return this.element.offsetTop;
            }
        },
        {
            key: 'left',
            get: function get() {
                return this.element.style.left;
            },
            set: function set(left) {
                this.element.style.left = left;
            }
        },
        {
            key: 'top',
            get: function get() {
                return this.element.style.top;
            },
            set: function set(top) {
                this.element.style.top = top;
            }
        },
        {
            key: 'x',
            get: function get() {
                return this._x;
            },
            set: function set() {
                var x = arguments.length <= 0 || arguments[0] === undefined ? 0 : arguments[0];
                if (!this.isGrid) {
                    var width = this.zone.width || this.lastZone.width;
                    this.left = this.xPercent = x / width * 100 + '%';
                } else {
                    this.left = this.xPercent = 0;
                }
                this.element.dataset.x = this._x = x;
            }
        },
        {
            key: 'y',
            get: function get() {
                return this._y;
            },
            set: function set() {
                var y = arguments.length <= 0 || arguments[0] === undefined ? 0 : arguments[0];
                if (!this.isGrid) {
                    var height = this.zone.height || this.lastZone.height;
                    this.top = this.yPercent = y / height * 100 + '%';
                } else {
                    this.top = this.yPercent = 0;
                }
                this.element.dataset.y = this._y = y;
            }
        }
    ]);
    return Tile;
}();
function getPosition(element) {
    if (element.length)
        element = element[0];
    var rect = element.getBoundingClientRect();
    var doc = document.documentElement;
    var scrollLeft = window.scrollX || doc.scrollLeft || body.scrollLeft || 0;
    var scrollTop = window.scrollY || doc.scrollTop || body.scrollTop || 0;
    var clientLeft = doc.clientLeft || body.clientLeft || 0;
    var clientTop = doc.clientTop || body.clientTop || 0;
    return {
        x: rect.left + scrollLeft - clientLeft,
        y: rect.top + scrollTop - clientTop
    };
}
zones = zoneData.map(function (zone) {
    return new DropZone(zone);
});
$('#btnSubmit').click(function () {
    var description = $('input#description').val();
    var numm = $('#zone-3').children('.tile').length;
    if (description == '') {
        alert('Please fill in a description!');
        $('input#description').focus();
    } else if(numm == 0){
        alert('Please add at least one item to the outfit!');
    } else {
        var html = '<form action="http://ci.jitsejan.nl/outfits/add" method="post" id="submit-outfit-form">';
        html += '<input type="text" name="description" value="' + description + '" />';
        var uuid = $('input#uuid').val();
        html += '<input type="hidden" name="uuid" id="uuid" value="'+uuid+'" />';
        var offsettl = $('#topleft').offset();
        // alert("offset x: "+ offsettl.left + " offset y" + offsettl.top);
        html += '<input type="text" name="topleft" value="' + offsettl.left + ';' + offsettl.top + '" />';
        $('#zone-3').children('.tile').each(function () {
            var id = $(this).attr('data-id');
            var offset = $(this).offset();
            var zindex = $(this).css("z-index");
            // alert(id+"offset x: "+ offset.left + " offset y" + offset.top + " z-index " + zindex);
            html += '<input type="text" name="' + id + '" value="' + offset.left + ';' + offset.top + ';' + zindex + '" />';
        });
        html += '</form>';
        var form = $(html);
        $('body').append(form);
        $('#submit-outfit-form')[0].submit();
    }
});
