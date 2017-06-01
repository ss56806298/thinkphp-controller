function Dsy()
{
	this.Items = {};
}
Dsy.prototype.add = function(id,iArray)
{
	this.Items[id] = iArray;
}
Dsy.prototype.Exists = function(id)
{
	if(typeof(this.Items[id]) == "undefined") 
		return false;
	return true;
}
function change(v){
	var str = "0";
	for(i = 0; i < v; i++){ 
		str += ("_" + (document.getElementById(s[i]).selectedIndex-1));
	}
	var ss = document.getElementById(s[v]);
	with(ss){
		length = 0;
		options[0] = new Option(opt0[v], opt0[v]);
		if(v && document.getElementById(s[v-1]).selectedIndex>0 || !v)
		{
			if(dsy.Exists(str)){
				ar = dsy.Items[str];
				for(i = 0; i < ar.length; i++)
					options[length] = new Option(ar[i], ar[i]);
				if(v)options[1].selected = true;
			}
		}
		if(++v < s.length){
			change(v);
		}
	}
}

var dsy = new Dsy();

dsy.add("0",["NMA00001","NMA00002","SPA00001","SPA00002","SPA00003","SPA00004","ELA00001"]);

dsy.add("0_0",["NMD00001","NMD00002","NMD00003"]);

dsy.add("0_1",["NMD00004","NMD00005","NMD00006","NMD00007","NMD00008"]);

dsy.add("0_2",["SPD00001","SPD00002","SPD00003"]);

dsy.add("0_3",["SPD00004","SPD00005","SPD00006"]);

dsy.add("0_4",["SPD00007","SPD00008","SPD00009"]);

dsy.add("0_5",["SPD00010","SPD00011","SPD00012"]);

dsy.add("0_6",["ELD00001","ELD00002"]);

var s = ["area", "dungeon"];
var opt0 = ["区域", "副本"];
function setup()
{
	for(i = 0; i < s.length - 1; i++)
		document.getElementById(s[i]).onchange = new Function("change(" + (i + 1) + ")");
	change(0);
}