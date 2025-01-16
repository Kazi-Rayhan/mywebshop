<x-shop-front-end>
    @push('style')
        <style>
            #container {
                width: 640px;
                margin: 20px auto;
                padding: 10px;
            }

            #interactive.viewport {
                width: 1000px;
                height: 480px;
            }

            #interactive.viewport canvas,
            video {
                float: left;
                width: 640px;
                height: 480px;
            }

            #interactive.viewport canvas.drawingBuffer,
            video.drawingBuffer {
                margin-left: -640px;
            }

            .controls fieldset {
                border: none;
                margin: 0;
                padding: 0;
            }

            .controls .input-group {
                float: left;
            }

            .controls .input-group input,
            .controls .input-group button {
                display: block;
            }

            .controls .reader-config-group {
                float: right;
            }

            .controls .reader-config-group label {
                display: block;
            }

            .controls .reader-config-group label span {
                width: 9rem;
                display: inline-block;
                text-align: right;
            }

            .controls:after {
                content: "";
                display: block;
                clear: both;
            }

            #result_strip {
                margin: 10px 0;
                border-top: 1px solid #eee;
                border-bottom: 1px solid #eee;
                padding: 10px 0;
            }

            #result_strip>ul {
                padding: 0;
                margin: 0;
                list-style-type: none;
                width: auto;
                overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;
            }

            #result_strip>ul>li {
                display: inline-block;
                vertical-align: middle;
                width: 160px;
            }

            #result_strip>ul>li .thumbnail {
                padding: 5px;
                margin: 4px;
                border: 1px dashed #ccc;
            }

            #result_strip>ul>li .thumbnail img {
                max-width: 140px;
            }

            #result_strip>ul>li .thumbnail .caption {
                white-space: normal;
            }

            #result_strip>ul>li .thumbnail .caption h4 {
                text-align: center;
                word-wrap: break-word;
                height: 40px;
                margin: 0px;
            }

            #result_strip>ul:after {
                content: "";
                display: table;
                clear: both;
            }

            .scanner-overlay {
                display: none;
                width: 640px;
                height: 510px;
                position: absolute;
                padding: 20px;
                top: 50%;
                margin-top: -275px;
                left: 50%;
                margin-left: -340px;
                background-color: #fff;
                -moz-box-shadow: #333333 0px 4px 10px;
                -webkit-box-shadow: #333333 0px 4px 10px;
                box-shadow: #333333 0px 4px 10px;
            }

            .scanner-overlay>.header {
                position: relative;
                margin-bottom: 14px;
            }

            .scanner-overlay>.header h4,
            .scanner-overlay>.header .close {
                line-height: 16px;
            }

            .scanner-overlay>.header h4 {
                margin: 0px;
                padding: 0px;
            }

            .scanner-overlay>.header .close {
                position: absolute;
                right: 0px;
                top: 0px;
                height: 16px;
                width: 16px;
                text-align: center;
                font-weight: bold;
                font-size: 14px;
                cursor: pointer;
            }

            i.icon-24-scan {
                width: 24px;
                height: 24px;
                background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QzFFMjMzNTBFNjcwMTFFMkIzMERGOUMzMzEzM0E1QUMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QzFFMjMzNTFFNjcwMTFFMkIzMERGOUMzMzEzM0E1QUMiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpDMUUyMzM0RUU2NzAxMUUyQjMwREY5QzMzMTMzQTVBQyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpDMUUyMzM0RkU2NzAxMUUyQjMwREY5QzMzMTMzQTVBQyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PtQr90wAAAUuSURBVHjanFVLbFRVGP7ua97T9DGPthbamAYYBNSMVbBpjCliWWGIEBMWsnDJxkh8RDeEDW5MDGticMmGBWnSlRSCwgLFNkqmmrRIqzjTznTazkxn5s7c6/efzm0G0Jhwkj/nP+d/nv91tIWFBTQaDQWapkGW67p4ltUub5qmAi0UCqF/a/U2m81tpmddotwwDGSz2dzi4uKSaOucnJycGhsbe1XXdQiIIcdxEAgEtgXq9brySHCht79UXi/8QheawN27d385fPjwuEl6XyKR6LdtW7t06RLK5TKOHj2K/fv3Q87Dw8OYn5/HiRMnMDs7i5mZGQwODiqlPp8PuVwO6XRaOXb16lXl1OnTp5FMJvtosF8M+MWLarWqGJaWlpBKpRRcu3YN4+PjmJ6exsTEhDJw5coVjI6OKgPhcBiZTAbxeBx+vx+XL19Gd3c3Tp48Ka9zqDYgBlTQxYNgMIhIJKLCILkQb+TZsgvdsiyFi+feWRR7oRNZyanQtvW2V4DEUUBiK2eJpeDirSyhCe7F2QPh8fiEp72i9PbsC5G52DbiKZA771yr1dTuGfJ4PQNPFoAyQNR1aNEmsS5eyB3PgjeooMZd2AWvNmzYci/Gea7TeFOcI93jV/K67noGmi4vdRI9gPSDeMLSdKUBZZczlWm1rTtHjLZ24d+WER2tc8N1m+Y+ID74wx0zGYvhg9UNrJdtHJyZRdQfwPsrq9g99xsGlgsYmr6BNzO/IVwsYfjBQ6XYz6JI/72MV366B5/lw0elOkJWGUM3bmKtWjXSLuLaBWhnPnnp0FfoiFi4+TMfVAb2poBkDLjO845uYLEAjL4ALGWBP5YAOsP4AJYBFDaB1HOSVWD2PuV95H2RdV93Lv74/cf6p6Zxq/h6OofeOPJBC39JtONdwOAAViOs4p4OFGTf0Uc8iiyrr9YdQrUnDLsngrVOC0jQib44HlF2RafRZBz1Qy+vfhgK3NJZBlrm+LEm9qWwzFgLU7Ozg0JxZP06jQSRpQ7EerAWDSt6PuhHPmChEAog56fCLvJT5hHTm3OZkz3DyLx7XNWTGEA1GkV14gjWgwbW0ESVjYRwCOuai03L5E7OUBAV4kXSS4auoGIaKOma4m8EA5R1sMEGLh95C+XuLph0WJWpxepYYLtfT0RRgY1KgNODY6BoaChRuEhDCIZQYseuki5KN6hcQHiq7OZNv4/Zq2O6P4Lfkwn46vZjjaYZrIpvWbpzjLErrc4xUGE4avRedpYJalRcIl5hQius/SrPm9xrNOQYJhao6BvNUeWqtY8KaWuNjHOFAr7mM9f4NA4UbKysoUJ8PV9UzVOx6wxDDWUOxnK1pmCD07fOMAvtIsM3l89Dl3HRGhVma9AZMqjOnz2LQqWCxs6dqr3T7x1DTzKJaG8SekcHhg4cgI/56uKdlKnBV/WndqN3YAB/7tyBd3oT6GBIOzs7kc/nDfFdDFT5bS73cp06dQoaPa/Rw/rtO/resTHxxE2m9rCrbSR27UJCcMf1BpiA5rAAGgdfc868fUR1sMwj0cm9Iu9IctweisViB3hhKTHDcHc5jv/LspbyaZrR1OD82/fIlOkuB9LnEWRmDX2TsddUPg3D5gvuc0je0rZaD5EW6G3yjS+A3eeBEWq3XW/Abw1HhUspXADufQb86oW7tZytkYCN//3hHwBvDALPi8EnSOYK8DAOfCc2h4aGcO7cuafkzampqf9UripH12/DtOZbx8ciVGzYy5OO40o25ascGRl5Ssc/AgwAjW3JwqIUjSYAAAAASUVORK5CYII=");
                display: inline-block;
                background-repeat: no-repeat;
                line-height: 24px;
                margin-top: 1px;
                vertical-align: text-top;
            }

            @media (max-width: 603px) {
                #container {
                    width: 300px;
                    margin: 10px auto;
                    -moz-box-shadow: none;
                    -webkit-box-shadow: none;
                    box-shadow: none;
                }

                #container form.voucher-form input.voucher-code {
                    width: 180px;
                }
            }

            @media (max-width: 603px) {
                .reader-config-group {
                    width: 100%;
                }

                .reader-config-group label>span {
                    width: 50%;
                }

                .reader-config-group label>select,
                .reader-config-group label>input {
                    max-width: calc(50% - 2px);
                }

                #interactive.viewport {
                    width: 300px;
                    height: 300px;
                    overflow: hidden;
                }

                #interactive.viewport canvas,
                video {
                    margin-top: -50px;
                    width: 300px;
                    height: 400px;
                }

                #interactive.viewport canvas.drawingBuffer,
                video.drawingBuffer {
                    margin-left: -300px;
                }

                #result_strip {
                    margin-top: 5px;
                    padding-top: 5px;
                }

                #result_strip ul.thumbnails>li {
                    width: 150px;
                }

                #result_strip ul.thumbnails>li .thumbnail .imgWrapper {
                    width: 130px;
                    height: 130px;
                    overflow: hidden;
                }

                #result_strip ul.thumbnails>li .thumbnail .imgWrapper img {
                    margin-top: -25px;
                    width: 130px;
                    height: 180px;
                }
            }

            @media (max-width: 603px) {
                .overlay.scanner {
                    width: 640px;
                    height: 510px;
                    padding: 20px;
                    margin-top: -275px;
                    margin-left: -340px;
                    background-color: #fff;
                    -moz-box-shadow: none;
                    -webkit-box-shadow: none;
                    box-shadow: none;
                }

                .overlay.scanner>.header {
                    margin-bottom: 14px;
                }

                .overlay.scanner>.header h4,
                .overlay.scanner>.header .close {
                    line-height: 16px;
                }

                .overlay.scanner>.header .close {
                    height: 16px;
                    width: 16px;
                }
            }
        </style>
    @endpush

    {{-- <form action="{{ route('cart.store', request('user_name')) }}" method="post" id="cart" class="form-inline"
        style="display:none">
        @csrf
        <input type="hidden" name="method" value="self" style="display:hidden" />
        <input type="hidden" name="product_id" style="display:hidden" />

        <div class="row">
            <div class="input-group">
                <input type="hidden" class="form-control qty" value="1" min="1" name="quantity"
                    style="width:80px;display:hidden">
            </div>
        </div>

    </form> --}}
    <section id="container" class="container ">

        <span class="text-success" id="scanner_success"></span>

        <div id="interactive" class="viewport"></div>
        <div class="controls d-flex">
        </div>
    </section>


    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
            integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://webrtc.github.io/adapter/adapter-latest.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"
            integrity="sha512-bCsBoYoW6zE0aja5xcIyoCDPfT27+cGr7AOCqelttLVRGay6EKGQbR6wm6SUcUGOMGXJpj+jrIpMS6i80+kZPw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            const shop = {{ Iziibuy::userNameToId(request()->user_name) }};
            const user_name = "{{ request()->user_name }}";
            $(function() {
                var resultCollector = Quagga.ResultCollector.create({
                    capture: true,
                    capacity: 20,
                    blacklist: [{
                        code: "WIWV8ETQZ1",
                        format: "code_93"
                    }, {
                        code: "EH3C-%GU23RK3",
                        format: "code_93"
                    }, {
                        code: "O308SIHQOXN5SA/PJ",
                        format: "code_93"
                    }, {
                        code: "DG7Q$TV8JQ/EN",
                        format: "code_93"
                    }, {
                        code: "VOFD1DB5A.1F6QU",
                        format: "code_93"
                    }, {
                        code: "4SO64P4X8 U4YUU1T-",
                        format: "code_93"
                    }],
                    filter: function(codeResult) {
                        // only store results which match this constraint
                        // e.g.: codeResult
                        return true;
                    }
                });
                var App = {
                    init: function() {
                        var self = this;

                        Quagga.init(this.state, function(err) {
                            if (err) {
                                return self.handleError(err);
                            }
                            //Quagga.registerResultCollector(resultCollector);
                            App.attachListeners();
                            App.checkCapabilities();
                            Quagga.start();
                        });
                    },
                    handleError: function(err) {
                        console.log(err);
                    },
                    checkCapabilities: function() {
                        var track = Quagga.CameraAccess.getActiveTrack();
                        var capabilities = {};
                        if (typeof track.getCapabilities === 'function') {
                            capabilities = track.getCapabilities();
                        }
                        this.applySettingsVisibility('zoom', capabilities.zoom);
                        this.applySettingsVisibility('torch', capabilities.torch);
                    },

                    applySettingsVisibility: function(setting, capability) {
                        // depending on type of capability
                        if (typeof capability === 'boolean') {
                            var node = document.querySelector('input[name="settings_' + setting + '"]');
                            if (node) {
                                node.parentNode.style.display = capability ? 'block' : 'none';
                            }
                            return;
                        }
                        if (window.MediaSettingsRange && capability instanceof window.MediaSettingsRange) {
                            var node = document.querySelector('select[name="settings_' + setting + '"]');
                            if (node) {
                                setState
                                this.updateOptionsForMediaRange(node, capability);
                                node.parentNode.style.display = 'block';
                            }
                            return;
                        }
                    },

                    attachListeners: function() {
                        var self = this;


                        $(".controls").on("click", "button.stop", function(e) {
                            e.preventDefault();
                            Quagga.stop();
                            self._printCollectedResults();
                        });
                    },
                    _printCollectedResults: function() {
                        var results = resultCollector.getResults(),

                            $ul = $("#result_strip ul.collector");

                        results.forEach(function(result) {
                            var $li = $(
                                '<li><div class="thumbnail"><div class="imgWrapper"><img /></div><div class="caption"><h4 class="code"></h4></div></div></li>'
                            );
                            console.log(code);
                            $li.find("img").attr("src", result.frame);
                            $li.find("h4.code").html(result.codeResult.code + " (" + result.codeResult
                                .format + ")");
                            $ul.prepend($li);
                        });
                    },
                    _accessByPath: function(obj, path, val) {
                        var parts = path.split('.'),
                            depth = parts.length,
                            setter = (typeof val !== "undefined") ? true : false;

                        return parts.reduce(function(o, key, i) {
                            if (setter && (i + 1) === depth) {
                                if (typeof o[key] === "object" && typeof val === "object") {
                                    Object.assign(o[key], val);
                                } else {
                                    o[key] = val;
                                }
                            }
                            return key in o ? o[key] : {};
                        }, obj);
                    },


                    applySetting: function(setting, value) {
                        var track = Quagga.CameraAccess.getActiveTrack();
                        if (track && typeof track.getCapabilities === 'function') {
                            switch (setting) {
                                case 'zoom':
                                    return track.applyConstraints({
                                        advanced: [{
                                            zoom: parseFloat(value)
                                        }]
                                    });
                                case 'torch':
                                    return track.applyConstraints({
                                        advanced: [{
                                            torch: !!value
                                        }]
                                    });
                            }
                        }
                    },
                    inputMapper: {
                        inputStream: {
                            constraints: function(value) {
                                if (/^(\d+)x(\d+)$/.test(value)) {
                                    var values = value.split('x');
                                    return {
                                        width: {
                                            min: parseInt(values[0])
                                        },
                                        height: {
                                            min: parseInt(values[1])
                                        }
                                    };
                                }
                                return {
                                    deviceId: value
                                };
                            }
                        },
                        numOfWorkers: function(value) {
                            return parseInt(value);
                        },
                        decoder: {
                            readers: function(value) {
                                if (value === 'ean_extended') {
                                    return [{
                                        format: "ean_reader",
                                        config: {
                                            supplements: [
                                                'ean_5_reader', 'ean_2_reader', 'ean_128_reader'
                                            ]
                                        }
                                    }];
                                }
                                return [{
                                    format: value + "_reader",
                                    config: {}
                                }];
                            }
                        }
                    },
                    state: {
                        inputStream: {
                            type: "LiveStream",
                            constraints: {
                                width: {
                                    min: 640
                                },
                                height: {
                                    min: 480
                                },
                                facingMode: "environment",
                                aspectRatio: {
                                    min: 1,
                                    max: 2
                                }
                            }
                        },
                        locator: {
                            patchSize: "medium",
                            halfSample: true
                        },
                        numOfWorkers: 2,
                        frequency: 10,
                        decoder: {
                            readers: [{
                                format: "ean_reader",
                                config: {}
                            }]
                        },
                        locate: true
                    },
                    lastResult: null
                };

                App.init();

                Quagga.onProcessed(function(result) {
                    var drawingCtx = Quagga.canvas.ctx.overlay,
                        drawingCanvas = Quagga.canvas.dom.overlay;

                    if (result) {
                        if (result.boxes) {
                            drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(
                                drawingCanvas.getAttribute("height")));
                            result.boxes.filter(function(box) {
                                return box !== result.box;
                            }).forEach(function(box) {
                                Quagga.ImageDebug.drawPath(box, {
                                    x: 0,
                                    y: 1
                                }, drawingCtx, {
                                    color: "green",
                                    lineWidth: 2
                                });
                            });
                        }

                        if (result.box) {
                            Quagga.ImageDebug.drawPath(result.box, {
                                x: 0,
                                y: 1
                            }, drawingCtx, {
                                color: "#00F",
                                lineWidth: 2
                            });
                        }

                        if (result.codeResult && result.codeResult.code) {
                            Quagga.ImageDebug.drawPath(result.line, {
                                x: 'x',
                                y: 'y'
                            }, drawingCtx, {
                                color: 'red',
                                lineWidth: 3
                            });
                        }
                    }
                });

                Quagga.onDetected(function(result) {
                    var code = result.codeResult.code;
                    if (App.lastResult !== code) {
                        fetch(`/shop/${user_name}/cart/scanner-cart-store?ean=${code}&shop_id=${shop}`)
                            .then((response) => {
                                if (response.ok) {
                                    return response.json();
                                } else {
                                    throw new Error('Product not found');
                                }
                            })
                            .then((data) => {
                                $('#scanner_success').text(
                                    'Product Found. We are adding the product to cart. Please wait');
                                window.location.reload();
                            })
                            .catch((error) => {
                                alert('Error: ' + error.message);
                            });
                        App.lastResult = code;
                    }
                });

            });

            // function submitcart(data) {

            //     $("input[name='product_id']").val(data)
            //     $("#cart").submit();

            // }
        </script>
    @endpush
</x-shop-front-end>
