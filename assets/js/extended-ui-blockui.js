"use strict";

$((function() {
    var s = $("#section-block");
var e = $(".btn-section-block");
var c = $(".btn-section-block-overlay");
var t = $(".btn-section-block-spinner");
var o = $(".btn-section-block-custom");
var r = $(".btn-section-block-multiple");
var a = $("#card-block");
var l = $(".btn-card-block");
var i = $(".btn-card-block-overlay");
var n = $(".btn-card-block-spinner");
var v = $(".btn-card-block-custom");
var d = $(".btn-card-block-multiple");
var k = $(".btn-page-block");
var b = $(".btn-page-block-overlay");
var u = $(".btn-page-block-spinner");
var f = $(".btn-page-block-custom");
var p = $(".btn-page-block-multiple");
var g = $(".form-block");
var m = $(".btn-form-block");
var w = $(".btn-form-block-overlay");
var y = $(".btn-form-block-spinner");
var C = $(".btn-form-block-custom");
var S = $(".btn-form-block-multiple");
    e.length && s.length && e.on("click", (function() {
        $("#section-block").block({
            message: '<div class="spinner-border text-white" role="status"></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), c.length && s.length && c.on("click", (function() {
        $("#section-block").block({
            message: '<div class="spinner-border text-primary" role="status"></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                border: "0"
            },
            overlayCSS: {
                backgroundColor: "#fff",
                opacity: .8
            }
        });
    })), t.length && s.length && t.on("click", (function() {
        $("#section-block").block({
            message: '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), o.length && s.length && o.on("click", (function() {
        $("#section-block").block({
            message: '<div class="d-flex justify-content-center"><p class="mb-0">Please wait...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), r.length && s.length && r.on("click", (function() {
        $("#section-block").block({
            message: '<div class="d-flex justify-content-center"><p class="mb-0">Please wait...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            },
            timeout: 5000,
            onUnblock: function() {
                $("#section-block").block({
                    message: '<p class="mb-0">Almost Done...</p>',
                    timeout: 5000,
                    css: {
                        backgroundColor: "transparent",
                        color: "#fff",
                        border: "0"
                    },
                    overlayCSS: {
                        opacity: .25
                    },
                    onUnblock: function() {
                        $("#section-block").block({
                            message: '<div class="p-3 bg-success">Success</div>',
                            timeout: 500,
                            css: {
                                backgroundColor: "transparent",
                                color: "#fff",
                                border: "0"
                            },
                            overlayCSS: {
                                opacity: .25
                            }
                        });
                    }
                });
            }
        });
    })), l.length && a.length && l.on("click", (function() {
        $("#card-block").block({
            message: '<div class="spinner-border text-white" role="status"></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), i.length && a.length && i.on("click", (function() {
        $("#card-block").block({
            message: '<div class="spinner-border text-primary" role="status"></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                border: "0"
            },
            overlayCSS: {
                backgroundColor: "#fff",
                opacity: .8
            }
        });
    })), n.length && a.length && n.on("click", (function() {
        $("#card-block").block({
            message: '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), v.length && a.length && v.on("click", (function() {
        $("#card-block").block({
            message: '<div class="d-flex justify-content-center"><p class="mb-0">Please wait...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), d.length && a.length && d.on("click", (function() {
        $("#card-block").block({
            message: '<div class="d-flex justify-content-center"><p class="mb-0">Please wait...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            },
            timeout: 5000,
            onUnblock: function() {
                $("#card-block").block({
                    message: '<p class="mb-0">Almost Done...</p>',
                    timeout: 5000,
                    css: {
                        backgroundColor: "transparent",
                        color: "#fff",
                        border: "0"
                    },
                    overlayCSS: {
                        opacity: .25
                    },
                    onUnblock: function() {
                        $("#card-block").block({
                            message: '<div class="p-3 bg-success">Success</div>',
                            timeout: 500,
                            css: {
                                backgroundColor: "transparent",
                                color: "#fff",
                                border: "0"
                            },
                            overlayCSS: {
                                opacity: .25
                            }
                        });
                    }
                });
            }
        });
    })), k.length && k.on("click", (function() {
        $.blockUI({
            message: '<div class="spinner-border text-white" role="status"></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), b.length && b.on("click", (function() {
        $.blockUI({
            message: '<div class="spinner-border text-primary" role="status"></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                border: "0"
            },
            overlayCSS: {
                backgroundColor: "#fff",
                opacity: .8
            }
        });
    })), u.length && u.on("click", (function() {
        $.blockUI({
            message: '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), f.length && f.on("click", (function() {
        $.blockUI({
            message: '<div class="d-flex justify-content-center"><p class="mb-0">Please wait...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), p.length && p.on("click", (function() {
        $.blockUI({
            message: '<div class="d-flex justify-content-center"><p class="mb-0">Please wait...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            },
            timeout: 5000,
            onUnblock: function() {
                $.blockUI({
                    message: '<p class="mb-0">Almost Done...</p>',
                    timeout: 5000,
                    css: {
                        backgroundColor: "transparent",
                        color: "#fff",
                        border: "0"
                    },
                    overlayCSS: {
                        opacity: .5
                    },
                    onUnblock: function() {
                        $.blockUI({
                            message: '<div class="p-3 bg-success">Success</div>',
                            timeout: 500,
                            css: {
                                backgroundColor: "transparent",
                                color: "#fff",
                                border: "0"
                            },
                            overlayCSS: {
                                opacity: .5
                            }
                        });
                    }
                });
            }
        });
    })), m.length && g.length && m.on("click", (function() {
        g.block({
            message: '<div class="spinner-border text-white" role="status"></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), w.length && g.length && w.on("click", (function() {
        g.block({
            message: '<div class="spinner-border text-primary" role="status"></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                border: "0"
            },
            overlayCSS: {
                backgroundColor: "#fff",
                opacity: .8
            }
        });
    })), y.length && g.length && y.on("click", (function() {
        g.block({
            message: '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), C.length && g.length && C.on("click", (function() {
        g.block({
            message: '<div class="d-flex justify-content-center"><p class="mb-0">Please wait...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            timeout: 5000,
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            }
        });
    })), S.length && g.length && S.on("click", (function() {
        g.block({
            message: '<div class="d-flex justify-content-center"><p class="mb-0">Please wait...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0"
            },
            overlayCSS: {
                opacity: .5
            },
            timeout: 5000,
            onUnblock: function() {
                g.block({
                    message: '<p class="mb-0">Almost Done...</p>',
                    timeout: 5000,
                    css: {
                        backgroundColor: "transparent",
                        border: "0"
                    },
                    overlayCSS: {
                        opacity: .25
                    },
                    onUnblock: function() {
                        g.block({
                            message: '<div class="p-3 bg-success">Success</div>',
                            timeout: 5000,
                            css: {
                                backgroundColor: "transparent",
                                border: "0"
                            },
                            overlayCSS: {
                                opacity: .25
                            }
                        });
                    }
                });
            }
        });
    }));
}));