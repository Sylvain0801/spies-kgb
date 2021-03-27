window.onload = () => {
  let [iId, iName, iColor] = document.querySelectorAll('#inputId, #inputName, #inputColor')
  const btnSave = document.getElementById('save')
  const route = btnSave.dataset.route
  console.log(btnSave);
  btnSave.addEventListener('click', function() {
    let [id, name, color] = [iId.value, iName.value, iColor.value.substring(1, iColor.value.length)]
    let xhr = new XMLHttpRequest()
    xhr.open("get", `/admin/${route}/edit/${id}/${name}/${color}`)
    xhr.addEventListener('readystatechange', function() {
      if(xhr.readyState === 4) {
          if(xhr.status !== 200) {
            alert('Une erreur s\'est produite, veuillez réessayer plus tard !')
          } else {
            document.getElementById('name_' + id).textContent = name
            document.getElementById('color_' + id).style.backgroundColor = '#' + color
            document.getElementById('btn_' + id).setAttribute('data-name', name)
            document.getElementById('btn_' + id).setAttribute('data-color', '#' + color)
            inputId.value = inputColor.value = inputName.value = ''
            alert('La sélection a été mise à jour avec succès.')
          }
        }
      })
    xhr.send()
  })
  const btnCreate = document.getElementById('create')
  btnCreate.addEventListener('click', function() {
    let [name, color] = [iName.value, iColor.value.substring(1, iColor.value.length)]
    if (name) {
      let xhr = new XMLHttpRequest()
      xhr.open("get", `/admin/${route}/new/${name}/${color}`)
      xhr.addEventListener('readystatechange', function() {
        if(xhr.readyState === 4) {
          if(xhr.status !== 200) {
            alert('Une erreur s\'est produite, veuillez réessayer plus tard !')
          } else {
              let json = xhr.response
              if(typeof json === 'string') {
                json = json.substring(0, json.indexOf('}') + 1)
              }
              json = JSON.parse(json)
              id = json.newid
              const tBody = document.querySelector('tbody')
              tBody.insertAdjacentHTML('beforeend', 
              `<tr>
                <td id="name_${id}">${name}</td>
                <td>
                  <div id="color_${id}" class="color-display" style="background-color:#${color}"></div>
                </td>
                <td>
                  <a id="btn_${id}" class="button small icon fa-pencil btn-edit" role="button" title="Editer" data-id="${id}" data-name="${name}" data-color="${color}"></a>
                  <a class="button primary small icon fa-trash btn-delete" role="button" title="Supprimer" data-id="${id}" onclick="return confirm('Le statut ${name} va être définitivement supprimé, ce choix doit être confirmé ?')"></a>
                </td>
              </tr>`
              )
              editButtons()
              deleteButtons()
              inputId.value = inputColor.value = inputName.value = ''
              alert('La sélection a été mise à jour avec succès.')
            }
          }
        })
      xhr.send()
      btnDelete = document.querySelectorAll('a.btn-delete')
    } else {
      alert('Le champ nom est requis !')
    }
  })

  const editButtons = () => {
    let btnEdit = document.querySelectorAll('a.btn-edit')
    for (let btn of btnEdit) {
      btn.addEventListener('click', function() {  
        iId.value = this.dataset.id
        iName.value = this.dataset.name
        this.dataset.color && (iColor.value = this.dataset.color)
      })
    }
  }

  const deleteButtons = () => {
    let btnDelete = document.querySelectorAll('a.btn-delete')
    for (let btn of btnDelete) {
      btn.addEventListener('click', function() {  
        let xhr = new XMLHttpRequest()
        let id = this.dataset.id
        xhr.open("get", `/admin/${route}/delete/${id}`)
        xhr.addEventListener('readystatechange', function() {
          if(xhr.readyState === 4) {
            if(xhr.status !== 200) {
              alert('Une erreur s\'est produite, veuillez réessayer plus tard !')
            } else {
              document.getElementById('name_' + id).parentNode.remove()
              alert('La sélection a été supprimée avec succès.')
            }
          }      
        })
        xhr.send()
      })
    }
  }
  editButtons()
  deleteButtons()
}
