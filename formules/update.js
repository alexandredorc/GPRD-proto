function update(response,doc) {
    if(response){
        response = JSON.parse(response);
        doc[4].children[0].value=response[1];
        doc[6].children[0].value=response[3]+" €";
        var price=doc[5].children[0].value
        var price = parseFloat(price.replace(" €", ""),5);
        doc[7].children[0].value=(response[3]*price/100)+" €";
        doc[8].children[0].checked = (response[9]=="VRAI")?true:false;
        var prcnt=doc[5].children[0].value
        var prcnt = parseFloat(prcnt.replace("%", ""),5);
        for(var i=0;i<4;i++){
            doc[9+i*2].children[0].value=response[12+i];
            doc[10+i*2].children[0].value=(response[12+i]!="")?((response[12+i]*prcnt)+"%"):"0%";
        }
        doc[17].children[0].value=response[4]
        doc[18].children[0].value=response[5]
    }else{
        doc[4].children[0].value="";
        doc[6].children[0].value="";
        doc[7].children[0].value="";
        doc[8].children[0].checked = false;
        for(var i=0;i<4;i++){
            doc[9+i*2].children[0].value=""
            doc[10+i*2].children[0].value="0%";
        }
        doc[17].children[0].value=""
        doc[18].children[0].value=""
    }
}
$(".MP").on('input',function() {
var doc=this;
doc=doc.parentNode.parentNode.children
$.ajax({
type: "POST",
url: "func_update.php",
data: {functionname: 'update', arguments: this.value }
}).done(function (response){update(response,doc)});
});

$(".prcnt").on('input',function() {
var doc=this;
var val=this.value;
doc=doc.parentNode.parentNode.children
if(val!=""){
        var price=doc[6].children[0].value;
        var price = parseFloat(price.replace(" €", ""),5);
        var prcnt= parseFloat(val.replace("%",""),5);
        doc[7].children[0].value=(prcnt!="")?((prcnt*price/100)+" €"):"0 €";
        for(var i=0;i<4;i++){
            doc[10+i*2].children[0].value=(doc[9+i*2].children[0].value!="")?((doc[9+i*2].children[0].value*prcnt)+"%"):"0%";
        }       
}else{
    doc[7].children[0].value="0 €";
    for(var i=0;i<4;i++){
        doc[10+i*2].children[0].value="0%";
    }
}
});



$(".check_phase").on('change',function() {
    var doc=this;
    var val=this.value;
    var tab= document.getElementById("tableau");
    var nb=-1;
    var alpha="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for(var i=0; i<tab.childElementCount-1;i++){
        if(tab.children[i].children[0].children[0].checked){
            nb+=1;
        }
        if(nb!=-1){
            var phase="";
            if (nb>=26){
                var unit=nb%26;
                var dec=(nb-unit)/26;
                phase=alpha[dec-1]+alpha[unit];
            }
            else{
                phase=alpha[nb];
            }
            tab.children[i].children[1].children[0].value=phase;
        }
    }
    });