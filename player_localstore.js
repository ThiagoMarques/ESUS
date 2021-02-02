/**
 * SE/UNA-SUS LocalStorage PPU Player
 * Apenas para testes locais, não deve ser utilizado em ambiente de produção
 * @author Onivaldo Rosa Junior 
 * @copyright Secretaria Executiva da UNA-SUS 2016
 * @version 1.0.0
 * @license LGPLv3
 */
 
SE_UNASUS_PLAYER_API = {
    _STATE: {
        NOT_INITIALIZED: -1,
        RUNNING: 0,
        TERMINATED: 1,
    },
	_IsJsonString : function(str) {
		try {
			JSON.parse(str);
		} catch (e) {
			return false;
		}
		return true;
	},	
    _get_user_data: function () {
		var user_data = new Object();
		user_data.Id = 2016;
		user_data.RealName = 'Fulano de Tal';
        return user_data;
    },	
    version: "1.0.0",
    name: "SE/UNA-SUS LocalStorage Player",
    state: -1,
    debug: true,
    last_error: 0,
    user_info: null,
    UUID: null,
    cached: false, // não se aplica a localStorage
	config: null,
    debugMessage: function (strlog) {
        console.log('Player DEBUG: ' + strlog);
    },
	getLastError: function() {
		return this.last_error;
	},
    initialize: function () {		
		if (!window.localStorage) {
            this.last_error = 'SE/UNA-SUS LocalStorage Player: LocalStorage não disponível, utilize outro navegador.';
            return false;			
		}
        if (this.state === this._STATE.RUNNING) {
            return true;
        }
        if (this.state === this._STATE.TERMINATED) {
            this.last_error = 'SE/UNA-SUS LocalStorage Player: Não inicializado.';
            return false;
        }
        var userdata = this._get_user_data();
        if (userdata === false) {
            this.last_error = 'SE/UNA-SUS LocalStorage Player: Erro ao obter informações do usuário.';
            return false;
        } else {
			if (this.debug)
                console.log("SE/UNA-SUS LocalStorage Player: Informações do usuário carregadas.");			
            this.user_info = userdata;
        }
        if (this.debug)
            console.log("SE/UNA-SUS LocalStorage Player: Inicialização completa");		
        this.state = this._STATE.RUNNING;
        this.last_error = false;
        return true;
    },
    terminate: function () {
        if (this.state === this._STATE.NOT_INITIALIZED) {
            this.last_error = 'SE/UNA-SUS LocalStorage Player: Não inicializado.';
            return false;
        }
        if (this.state === this._STATE.TERMINATED) {
            this.last_error = 'SE/UNA-SUS LocalStorage Player: Já finalizado.';
            return false;
        }		
        this.state = this._STATE.TERMINATED;
        var ret = this.setItem('SE/UNA-SUS LocalStorage Player', '{"Status":"' + this.state + '"}');
        if (!ret) {
            this.last_error = 'SE/UNA-SUS LocalStorage Player: Erro ao gravar finalização.';
            return false;			
        }
        if (this.debug)
            console.log("SE/UNA-SUS LocalStorage Player: Finalização completa.");
        return true;
    },
	getItem: function(Item) {
		var data = localStorage.getItem(Item);
		if (data !== null) {
			if (this._IsJsonString(data)) {
				return data;
			} else {
				return false;
			}
		} else {
			return null;
		}
	},
	setItem: function(Item,Valor) {
		if (!this._IsJsonString(Valor)) {
			return false;
		}
		try {
			localStorage.setItem(Item,Valor);
		} catch(err) {
			return false;
		}
		return true;
	},
    getPlayerUser: function () {
        return this.user_info;
    },
    getPlayerVersion: function () {
        return this.version;
    },
    getPlayerName: function () {
        return this.name;
    },
	getBasename: function () {
		if (this.state === this._STATE.RUNNING) {
			return this.config["Persistence"]["InstitutionAcronym"] + "_" + this.config["Persistence"]["Version"] + "_" + this.config["Persistence"]["Name"] + "_";
		} else {
			return false;
		}
 	},
	getVideoResolutions: function () {
		return this.config["Video"]["Resolutions"];
	}	
};