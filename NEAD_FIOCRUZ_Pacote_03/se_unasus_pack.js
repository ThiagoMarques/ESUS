/**
 * Biblioteca SE_UNASUS_PACK para Recursos Educacionais Interativos em HTML5.
 * @author Onivaldo Rosa Junior 
 * @copyright Secretaria Executiva da UNA-SUS 2020
 * @version 1.1.0 
 * @requires se_unasus_pack.json
 * @license LGPLv3 
 */

/**
 * Construtor SE_UNASUS_PACK
 * @constructor
 */

function SE_UNASUS_PACK() {
	this._initialized = false;
}

/**
 * Procura SE_UNASUS_PLAYER_API na janela atualmente aberta no navegador ou janelas parentes.
 * @protected
 * @return {Object|null} Retorna SE_UNASUS_PLAYER_API ou null caso não encontre a API
 */

SE_UNASUS_PACK.prototype._findAPI = function(win) {
	var findAPITries = 0;
	try {
		while ((win.SE_UNASUS_PLAYER_API == null) && (win.parent != null) && (win.parent != win))
		{	
			findAPITries++;	
			if (findAPITries > 500)
			{
				this._errorMessage = 'Erro ao procurar API.';
				this.alertMessage(this._errorMessage);
			}
			win = win.parent;
	   }
	   return win.SE_UNASUS_PLAYER_API;
   } catch (e){
	   this._errorMessage = 'Erro ao procurar API, utilize outro navegador.';
	   this.alertMessage(this._errorMessage);
	   return null;
   }
}

SE_UNASUS_PACK.prototype._getAPI = function() {
	var theAPI = this._findAPI(window);
	if (theAPI == null) {
		return false;
	} else {
		return theAPI;
	}
}

/**
 * Carrega um arquivo JSON usando AJAX.
 * @protected
 * @param {String} filePath - Caminho completo para o arquivo
 * @return {Object|null} Retorna um objeto a partir do JSON ou null em caso de falha.
 */
 
SE_UNASUS_PACK.prototype._loadJSON = function(filePath) {
	var load = null;
	try {
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.open("GET",filePath,false);
		xmlhttp.overrideMimeType("application/json");
		xmlhttp.send();
		if (xmlhttp.status==200) {
			var load = JSON.parse(xmlhttp.responseText);
		}		
	} catch(err) {
		load = null;
	}
	return load;
}

/**
 * Gera mensagem de API não inicializada, trocando o conteúdo do documento atual.
 * @protected 
 * @return {Boolean} Retorna sempre true
 */
 
SE_UNASUS_PACK.prototype._notInitializedMessage = function() {
	this.debugMessage('Player não inicializado!');
	document.body.parentNode.innerHTML = "<h2>Player não inicializado!</h2>";
	return true;
}	

/**
 * Retorna status de debug da API, caso API não inicializada gera mensagem de API não inicializada.
 * @return {Boolean|null} Retorna o status de debug da API (true ou false) ou null se API não inicializada.
 */
 
SE_UNASUS_PACK.prototype.getDebug = function() {
	if (this._initialized) {	
		return this._api.debug;
	}
	this._notInitializedMessage();
	return null;	
}

/**
 * Seta status de debug da API, caso API não inicializada gera mensagem de API não inicializada.
 * @param {Boolean} debug - Valores true para ativar as mensagens de debug ou false desabilita-las.
 * @return {Boolean|null} Retorna true se status de debug da API foi setado ou null se API não inicializada.
 */

SE_UNASUS_PACK.prototype.setDebug = function(debug) {
	if (this._initialized) {	
		if (debug) {
			this._api.debug = true;
		} else {
			this._api.debug = false;
		}
		return true;
	}
	this._notInitializedMessage();
	return null;
}

/**
 * Se API inicializada e debug ativado, envia mensagem pela API, se API não inicializada emite debug utilizando console.log
 * @param {String} str - Mensagem textual de debug
 * @return {true}
 */
 
SE_UNASUS_PACK.prototype.debugMessage = function(str) {
	if (this._initialized) {
		if (this._api.debug) {
			this._api.debugMessage(str);
		}
	} else {
		//console.log('DEBUG: '+str);
	}
	return true;
}

/**
 * Inicializa API, em caso de erro emite mensagens de debug e substitui o conteúdo por uma mensagem de erro.
 * @return {Boolean} Retorna true se inicializada ou false se não inicializada.
 */
 
SE_UNASUS_PACK.prototype.initialize = function() {
	this._api = this._getAPI();
	this._error = false;
	if (this._api === false) {
		document.body.parentNode.innerHTML = "<h2>Este conteúdo não deve ser acessado diretamente.</br></br>Nenhuma interface de player SE_UNASUS_PLAYER_API encontrada!</h2>"
		return false;		
	} else {		
		this.debugMessage("Adaptador SE_UNASUS_PLAYER_API encontrado.");

		this._api.config = this._loadJSON("se_unasus_pack.json");
		
		if (this._api.config === null) {
			this.debugMessage("Não é possível ler se_unasus_pack.json ou formato inválido");
			document.body.parentNode.innerHTML = "<h2>Não foi possível ler o arquivo de configuração deste conteúdo.</h2>"
			return false;
		}
		this.debugMessage("Arquivo de configuração carregado.");					
		if (this._api.state === this._api._STATE.RUNNING) {
			this._initialized = true;
			return true;			
		} else {
			try {
				this.debugMessage("Inicializando player.");
				if (!this._api.initialize()) {					
					document.body.parentNode.innerHTML = "<h2>"+this._api.getLastError()+"</h2>"
					return false;					
				}
			} catch (error) {
				this.debugMessage(error);
				document.body.parentNode.innerHTML = "<h2>Não foi possível inicializar o player para este conteúdo.</h2>"
				return false;
			}
			this.debugMessage("Player inicializado.");
			this._initialized = true;
			return true;			
		}
	}

}

/**
 * Retorna status de inicialização da API
 * @return {Boolean} Retorna true se inicializada ou false se não inicializada.
 */
 
SE_UNASUS_PACK.prototype.isInitialized = function() {
	return this._initialized;
}

/**
 * Retorna a configuração do pacote, carregada na inicialização da API
 * @return {Object|null} Retorna um objeto representando o arquivo de configuração do pacote (se_unasus_pack.json) ou null se API não inicializada.
 */
 
SE_UNASUS_PACK.prototype.getConfig = function() {
	if (this._initialized) {
		return this._api.config;
	}
	this._notInitializedMessage();
	return null;
}

/**
 * Retorna o basename do pacote setado na configuração, é utilizado como referência para evitar colisão de variáveis.
 * @return {String|null} Retorna o basename do pacote ou null se API não inicializada. basename = InstitutionAcronym + '_' + Version + '_' + Name + '_'
 */
 
SE_UNASUS_PACK.prototype.getBasename = function() {
	if (this._initialized) {	
		return this._api.getBasename();
	}
	this._notInitializedMessage();
	return null;	
}

/**
 * Retorna a versão do player onde está rodando o pacote.
 * @return {String|null} Retorna a versão do player ou null se API não inicializada.
 */
 
SE_UNASUS_PACK.prototype.getPlayerVersion = function() {
	if (this._initialized) {	
		return this._api.getPlayerVersion();
	}
	this._notInitializedMessage();
	return null;	
}

/**
 * Retorna o nome do player onde está rodando o pacote.
 * @return {String|null} Retorna o nome do player ou null se API não inicializada.
 */
 
SE_UNASUS_PACK.prototype.getPlayerName = function() {
	if (this._initialized) {	
		return this._api.getPlayerName();
	}
	this._notInitializedMessage();
	return null;
}

/**
 * Retorna dados do usuário, os dados mínimos são RealName e Id
 * @return {Object|null} Retorna um objeto com as propriedades RealName e Id, representando o usuário ou null se API não inicializada.
 */
 
SE_UNASUS_PACK.prototype.getPlayerUser = function() {
	if (this._initialized) {	
		return this._api.getPlayerUser();
	}
	this._notInitializedMessage();
	return null;	
}

/**
 * Retorna o Nome completo do usuário no player
 * @return {String|null} Retorna o Nome completo do usuário ou null se API não inicializada.
 */
 
SE_UNASUS_PACK.prototype.getPlayerUserRealName = function() {
	if (this._initialized) {	
		return this._api.getPlayerUser().RealName;
	}
	this._notInitializedMessage();
	return null;	
}

/**
 * Retorna o Id do usuário no player
 * @return {String|null} Retorna o Id do usuário ou null se API não inicializada.
 */
 
SE_UNASUS_PACK.prototype.getPlayerUserId = function() {
	if (this._initialized) {	
		return this._api.getPlayerUser().Id;
	}
	this._notInitializedMessage();
	return null;	
}

/**
 * Retorna as extensões suportadas pelo playerr
 * @return {String|null} Retorna um array de strings com as extensões suportadas ou null caso o player não suporte nenhum extensão.
 */
 
SE_UNASUS_PACK.prototype.getPlayerExtensions = function() {
	if (this._initialized) {
		try {
			extensions = this._api.getPlayerUser().Extensions;
			if (Array.isArray(extensions)) {
				return this._api.getPlayerUser().Extensions;
			} else {
				return null;
			}
		} catch (e) {
			return null;
		}
	}
	this._notInitializedMessage();
	return null;	
}
			
/**
 * Retorna um array com as resoluções de vídeo suportadas pelo pacote
 * @return {Array|null} Retorna um array com as resoluções de vídeo suportadas pelo pacote ou null se API não inicializada.
 */
 
SE_UNASUS_PACK.prototype.getVideoResolutions = function() {
	if (this._initialized) {
		return this._api.getVideoResolutions();
	}
	this._notInitializedMessage();
	return null;	
}

/**
 * Seta o valor de uma variável persistente (que será armazenada pelo player)
 * @param {String} item - Nome da variável persistente
 * @param {Object} obj - Objeto representado o valor da variável persistente, deve permitir a conversão utilizando JSON.stringify
 * @return {Boolean|null} Retorna null se API não inicializada, true se a variável foi setada ou false se a persistência falhou.
 */

SE_UNASUS_PACK.prototype.setPersistence = function(item, obj) {
	if (this._initialized) {	
		value = JSON.stringify(obj);
		if (this._api.setItem(this.getBasename() + item, value)===false) {
			this.debugMessage("Falha: setPersistence"+"=>"+item+":"+value+".");
			document.body.parentNode.innerHTML = "<h2>Falha ao gravar dados!</h2>"
			return false;			
		} else {
			this.debugMessage("Sucesso: setPersistence"+"=>"+item+":"+value+".");
		}
		return true;
	}
	this._notInitializedMessage();
	return null;
}

/**
 * Retorna um objeto representando o último valor de uma variável persistente (armazenada pelo player)
 * @param {String} item - Nome da variável persistente
 * @return {Object|null} Retorna um objeto representando o status atual da interação do usuário com o pacote,
 * null se houve falha ou API não inicializada, undefined se não existe valor armazenado no player.
 */
 
SE_UNASUS_PACK.prototype.getPersistence = function(item) {
	var dataitem;
	if (this._initialized) {
		var value = this._api.getItem(this.getBasename() + item);
		if (value===false) {
			this.debugMessage("Falha: getPersistence"+"=>"+item+".");
			document.body.parentNode.innerHTML = "<h2>Falha ao ler dados!</h2>"
			return null;
		} else {
			if (value===null) {
				return dataitem;
			}
			try {
				dataitem = JSON.parse(value);
			} catch (e) {
				this.debugMessage("Valor nulo ou inválido: getPersistence"+"=>"+item+".");
				return null;
			}		
			this.debugMessage("Sucesso: getPersistence"+"=>"+item+":"+value+".");
			return dataitem;
		}
	}
	this._notInitializedMessage();
	return null;
}

/**
 * Seta a variável persistente padronizada STATUS
 * @param {Object} status - Objeto representando o status atual da interação do usuário com o pacote
 * status.status => valor nominal textual do status podendo ter os seguintes valores "attended", "attempted", "completed", "passed", "failed"
 * status.percentage => valor inteiro entre 0 e 100
 * status.LTIvalue => valor ponto flutuante entre 0 e 1
 * Outras propriedades devem ser adicionadas ao status, conforme a necessidade da cada pacote, e documentadas no arquivo de configuração se_unasus_pack.json
 * @return {Boolean|null} Retorna null se API não inicializada, true se a variável foi setada ou false se a persistência falhou. Esta função verifica a validade dos valores em status, percentage e LTIvalue.
 */
 
SE_UNASUS_PACK.prototype.setStatus = function(status) {
	var status_values = ["attended", "attempted", "completed", "passed", "failed"];
	if (status_values.indexOf(status.status) === -1) {
		this.debugMessage("Falha: valor inválido para status.status em setStatus." +status.staus);
		document.body.parentNode.innerHTML = "<h2>Falha ao gravar dados!</h2>"
		return false;
	}
	if (!(status.percentage>=0 && status.percentage<=100 && (status.percentage === +status.percentage && isFinite(status.percentage) && !(status.percentage % 1)))) {
		this.debugMessage("Falha: valor inválido para status.percentage em setStatus.");
		document.body.parentNode.innerHTML = "<h2>Falha ao gravar dados!</h2>"
		return false;
	}
	if (!(status.LTIvalue>=0 && status.LTIvalue<=1)) {
		this.debugMessage("Falha: valor inválido para status.LTIvalue em setStatus.");
		document.body.parentNode.innerHTML = "<h2>Falha ao gravar dados!</h2>"
		return false;
	}
	return this.setPersistence("STATUS", status);
}

/**
 * Retorna a variável persistente padronizada STATUS
 * @return {Object|null} Retorna um objeto representando o status atual da interação do usuário com o pacote,
 * null se houve falha ou API não inicializada, undefined se não existe valor armazenado no player.
 */
 
SE_UNASUS_PACK.prototype.getStatus = function() {
	return this.getPersistence("STATUS");
}

/**
 * Ativa uma extensão do Player PPU
 * @param {String} extension - Nome da extensão, deve ser um dos valores recebidos por getPlayerExtensions 
 * @param {Object} obj - Objeto representado o valor dos parâmetros a serempassados para a extensão, deve permitir a conversão utilizando JSON.stringify
 * @return {Boolean|null} Retorna null se API não inicializada, true se a extension foi chamada com sucesso ou false se a chamada falhou ou o player não suporta extensões.
 */

SE_UNASUS_PACK.prototype.setPlayerExtension = function(extension, obj) {
	if (this._initialized) {	
		value = JSON.stringify(obj);
		try {
			if (this._api.setExtension(extension, value)===false) {
				this.debugMessage("Falha: setExtension"+"=>"+extension+":"+value+".");
				return false;			
			} else {
				this.debugMessage("Sucesso: setExtension"+"=>"+extension+":"+value+".");
			}
			return true;
		} catch(e) {
			return false;
		}
	}
	this._notInitializedMessage();
	return null;
}

/**
 * Carrega SE_UNASUS_PACK na janela atual.
 */
 
window.unasus = window.unasus || {};
window.unasus.pack = window.unasus.pack || new SE_UNASUS_PACK();