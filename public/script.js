function search(search) {
    if ( $('#output').html().length > 3){
        window.location = '/result/' + $('#output').html()
        $('#wait-result').html(`We are looking for the best results for “${search}” on Amazon, It may take a short time. Please wait.`)
    }
}
