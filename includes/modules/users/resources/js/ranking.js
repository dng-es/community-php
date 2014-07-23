// JavaScript Document
jQuery(document).ready(function(){
	var timerPanel,
		panel = new PanelIni(),
		obj = new Object();

	panel.iniObj();
	timerPanel = setInterval( function(){
delete (panel);
delete (obj);
		panel.iniObj();
	}
	, 6000 );		
});

(function(global,undefined) {
	
	PanelIni = function() {		
		this.iniObj = function(){
			obj = null;
			$(".user-ranking").each(function(index){
				$(this).data("legend",$(this).html());
				obj = new PanelMov( $(this) );
				obj.panelChange();
			});	
		}
	};

	PanelMov = function(elemento){
		var panelTimer = null, panelCounter= 0, elem = elemento;

		this.panelChange = function(){
			panelTimer = setInterval( function(){
				PanelMov.prototype.elemento1 = elem;
				PanelMov.prototype.changeLetters();
			}, 100 );
		};

		PanelMov.prototype = {
			elemento1 : null,
			reloj: 0,
			changeLetters : function(){
				if (this.reloj>=55000){
					clearInterval(panelTimer);
					this.elemento1.html(this.elemento1.data("legend"));

					//this.elemento1 = null;
					//this.reloj =  0;
				}
				else{
					this.elemento1.html(this.randomString());
					this.reloj += 100;
				}
			},

			randomString : function() {
				var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz",
					string_length = Math.floor(Math.random() * 30) + 25;
					randomstring = '', rnum = 0, len = 0;

				for (var i = 0; i < (len = string_length); i++) {
					rnum = Math.floor(Math.random() * chars.length);
					randomstring += chars.substring(rnum,rnum+1);
				}

				//sustituyo algunos caracteres por blanco para mejorar efecto
				return randomstring.replace("0","&nbsp;")
								   .replace("1","&nbsp;")
								   .replace("2","&nbsp;")
								   .replace("3","&nbsp;")
								   .replace("4","&nbsp;");
			}
		}
	};
	//global.PanelMov = PanelMov;
	global.PanelIni = PanelIni;
})(this);