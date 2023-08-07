function search() {
    if ( $('#output').html().length > 3){
        window.location = '/result/' + $('#output').html()
    }
}
