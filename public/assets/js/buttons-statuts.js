window.onload = () => {
  let btnEdit = document.querySelectorAll('a.btn-edit')
  let inputId = document.querySelector('input#inputId')
  let inputName = document.querySelector('input#inputName')
  let inputColor = document.querySelector('input#inputColor')
  for (let btn of btnEdit) {
    btn.addEventListener('click', function() {  
      inputId.setAttribute('value', `${this.dataset.id}`)
      inputName.setAttribute('value', `${this.dataset.name}`)
      inputName.value = `${this.dataset.name}`
      inputColor.setAttribute('value', `${this.dataset.color}`)
      inputColor.value = `${this.dataset.color}`
    })
  }
  let btnSave = document.querySelector('#save')
  btnSave.addEventListener('click', function() {
    let id = inputId.value
    let name = inputName.value
    let color = inputColor.value
    color = color.substring(1, color.length)
    let xhr = new XMLHttpRequest
    xhr.open("get", `/admin/statute/edit/${id}/${name}/${color}/`)
    xhr.addEventListener('readystatechange', function() {
      if(xhr.readyState === 4) {
          if(xhr.status !== 200) {
            alert('Une erreur s\'est produite, veuillez réessayer plus tard !')
          } else {
            document.getElementById('name_' + id).textContent = name
            document.getElementById('color_' + id).style.backgroundColor = '#' + color
            inputId.removeAttribute('value')
            inputId.value = ''
            inputColor.removeAttribute('value')
            inputColor.value = '#000000'
            inputName.removeAttribute('value')
            inputName.value = ''
            document.getElementById('btn_' + id).setAttribute('data-name', name)
            document.getElementById('btn_' + id).setAttribute('data-color', '#' + color)
            alert('Le statut a été mis à jour avec succès.')
          }
        }
      })
    xhr.send()
  })
}
