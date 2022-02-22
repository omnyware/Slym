
let MODELS = [];
let TYPES = [];

$(function(){
  let brand = $("#brand-select").val();
  if(brand > 0){
    getModels($("#brand-select").val(), function(data){
      mountModel(data)
      MODELS = data;
      initTypeAfterValid();
    });
  }
  
});

function initTypeAfterValid(){
  let typeChosen = $("#type-chosen").val();
  if(typeChosen > 0){
    console.log($("#model-select").val())
    getTypes($("#model-select").val(), function(data){
      console.log("teste aki: " + data)
      TYPES = data;
      mountTypes(data)
    });
    setType(typeChosen)
  }
}

$("#brand-select").change(function(){
  getModels($("#brand-select").val(), function(data){
    mountModel(data)
  });
});

$("#model-select").change(function(){
    console.log($("#model-select").val())
    setImg($("#model-select").val())
    getTypes($("#model-select").val(), function(data){
      mountTypes(data);
    });
});

$("#type-select").change(function(){
  $("#type-chosen").val($("#type-select").val());
});

function getModelsRefresh(id){
  $.ajax
  ({
    type: 'POST',
    data: {
      _token: $("#_token").val(),
      id: id
    },
    url: path + 'modelos/byBrand',
    dataType: 'json',
      success: function(e){
        MODELS = e;
      }, error: function(e){
        console.log(e)
      }

  });
}

function getModels(id, data){
  $.ajax
  ({
    type: 'POST',
    data: {
      _token: $("#_token").val(),
      id: id
    },
    url: path + 'modelos/byBrand',
    dataType: 'json',
      success: function(e){
        MODELS = e;
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}

function getTypes(id, data){
  $.ajax
  ({
    type: 'POST',
    data: {
      _token: $("#_token").val(),
      id: id
    },
    url: path + 'tipoServico/byModel',
    dataType: 'json',
      success: function(e){
        console.log(e);
        TYPES = e;
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}

function mountModel(data){
  let options = "";
  let selected = "";
  $.each(data, function(index, value){
    console.log($("#model-chosen").val())
    if($("#model-chosen").val() == value.id){
      selected = "selected";
    }else{
      selected = "";
    }
    options += "<option value='" + value.id + "' "+selected+">"
    options += value.name
    options += "</option>";
  })

  $("#model-select").html(options);
  $("#model-select").material_select();
  if($("#model-chosen").val() <= 0){
    setFirstChoice();
    setFirstChoiceService();
  }else{
    let modelChosen = $("#model-chosen").val();
    if(modelChosen > 0){
      setImg(modelChosen)
    }
  }
}

function mountTypes(data){
  let options = "";
  let selected = "";
  $.each(data, function(index, value){
    console.log($("#type-chosen").val())
    if($("#type-chosen").val() == value.id){
      selected = "selected";
    }else{
      selected = "";
    }

    options += "<option value='" + value.id + "' "+selected+">"
    options += value.name
    options += "</option>";
  })

  $("#type-select").html(options);
  $("#type-select").material_select();
 // if($("#model-chosen").val() == null)
  
}

function setImg(id){
  $("#model-chosen").val(id);
  let img = "";
  let model = "";
  $.each(MODELS, function(index, value){
    if(value.id == id){
      img = value.img;
      model = value.name;
    }
  })

  let public_path = path + "imagens/modelos/";
  console.log(public_path+img)
  $("#img-phone").attr('src', public_path+img);
  $("#model-phone").html(model);
  $("#div-img-phone").css('display', 'block');
}

function setType(id){
  $.each(TYPES, function(index, value){
    console.log(value)
  })
}

function setFirstChoice(){
  setImg($("#model-select").val())
}

function setFirstChoiceService(){
  getTypes($("#model-select").val(), function(data){
      mountTypes(data);
  });
}
