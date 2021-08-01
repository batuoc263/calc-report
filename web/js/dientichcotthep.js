var kl = NaN;
var dm = NaN;
var sn = NaN;
var snf = false;
var koef = 1;
var zn = 3;
var razm = " mm&sup2;";
var summa = 0;
var closebutton = "<span class=close>&times;</span>";
var plusbutton = "<span class=plus>&plus;</span>";

function zrtrm(a) {
    while ("0" == a.charAt(a.length - 1)) {
        a = a.substring(0, a.length - 1)
    }
    if ("." == a.charAt(a.length - 1)) {
        a = a.substring(0, a.length - 1)
    }
    return a
}

function jdiam() {
    $(".tddiamblue").removeClass("tddiamblue");
    $(this).addClass("tddiamblue");
    dm = this.innerHTML;
    acalc()
}

function jkolvo() {
    $(".tdkolvoblue").removeClass("tdkolvoblue");
    $(this).addClass("tdkolvoblue");
    kl = 1 * this.innerHTML;
    snf = false;
    acalc()
}

function jsnap() {
    $(".tdkolvoblue").removeClass("tdkolvoblue");
    $(this).addClass("tdkolvoblue");
    sn = 1 * this.innerHTML;
    snf = true;
    kl = 1000 / this.innerHTML;
    acalc()
}

function acalc() {
    if (isFinite(kl) && isFinite(dm)) {
        var a = koef * Math.PI * dm * dm * 0.25;
        $("#rez").html("<i>A<sub>s</sub></i> = " + a.toFixed(zn) + " &times; " + zrtrm(kl.toFixed(zn)) + " = " + (a * kl).toFixed(zn) + razm + " (&empty;" + dm + " " + (snf ? ("шаг " + sn) : (zrtrm(kl.toFixed(zn)) + " шт.")) + ") ");
        $(".plus").remove();
        $("#rez").after(plusbutton);
        $(".plus").attr("title", "Thêm một dòng nữa").click(jcpy);
        $("#sum").html("&Sigma; <i>A<sub>s</sub></i> = " + (summa + a * kl).toFixed(zn) + razm)
    }
    if (!isFinite(dm)) {
        $("#rez").html("Укажите диаметр")
    }
    if (!isFinite(kl)) {
        $("#rez").html("Укажите количество либо шаг стержней")
    }
}

function jcpy() {
    if (isFinite(kl) && isFinite(dm)) {
        var a = koef * Math.PI * dm * dm * 0.25;
        summa += a * kl;
        $("#sum").html("&Sigma; <i>A<sub>s</sub></i> = " + summa.toFixed(zn) + razm);
        $("#cpy").prepend("<b area='" + (a * kl) + "'>" + $("#rez").html() + closebutton + "<br></b>");
        $(".close").off().click(jclose).attr("title", "Удалить строку");
        $(".tdkolvoblue").removeClass("tdkolvoblue");
        $(".tddiamblue").removeClass("tddiamblue");
        $("#rez").html("Укажите диаметр и количество стержней");
        $(".plus").remove();
        kl = NaN;
        sn = NaN;
        dm = NaN
    }
}

function jclose() {
    summa -= $(this).parent().attr("area");
    $("#sum").html("&Sigma; <i>A<sub>s</sub></i> = " + summa.toFixed(zn) + razm);
    acalc();
    $(this).parent().remove()
}
$("#tb1").children().children().children().click(jdiam);
$("#tb2").children().children().children().click(jkolvo);
$("#tb3").children().children().children().click(jsnap);