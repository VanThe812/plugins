
function displayFilesList(files) {
    let tmp = "";
    let names = "";
    for(let i=0; i<=files.length; i++) {
        if(files[i]){
            tmp += `<div class="files-list"> 
                        <span>${files[i].name}</span>
                    </div>`;
            names += `${files[i].name},`;
        }
    }
    // console.log(tmp);
    document.getElementById("countFile").innerText = `Selected ${files.length} files`;
    document.getElementById("displayFile").innerHTML = tmp;
    document.getElementById("plugin_asset_tempName").value = names;
} 
function getAllFile() {
    let files = document.getElementById("groupFile").files;
    // console.log(files);
    displayFilesList(files);
}