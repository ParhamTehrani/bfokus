function search() {
    if ( $('#output').html().length > 3){
        window.location = '/search/' + $('#output').html()
    }
}
