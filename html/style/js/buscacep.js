function buscacep(){
	var cep = $("input[name=cep]").val();
	if(cep.length < 9 || cep == ''){
		alert("Cep inválido");
	}else{
		$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("input[name=cep]").val(), function(){
		if(resultadoCEP["resultado"]){
			if(resultadoCEP["logradouro"] == ''){
				alert("Endereço não encontrado");
			}else{
				$("input[name=endereco-entrega]").val(unescape(resultadoCEP["tipo_logradouro"])+": "+unescape(resultadoCEP["logradouro"]));
				$("input[name=bairro]").val(unescape(resultadoCEP["bairro"]));
				$("input[name=cidade]").val(unescape(resultadoCEP["cidade"]));
				$("input[name=estado]").val(unescape(resultadoCEP["uf"]));
			}
		}else{
			alert("Endereço não encontrado");
			}
		});
	}			
}
