/* 
  ./public/js/posts/update.js
    AJAX request
*/


const action = confirm("This file name already exists. Press OK to replace your file with the saved one. Press Cancel to rename it or choose another one.");

if(action === false) {
  window.history.back();
}

else {

  const fileName = document.getElementById('fileName').value;

  const postText = (document.getElementById('postText') === null) ? '' : document.getElementById('postText').value;
  const postQuote = (document.getElementById('postQuote') === null) ? '' : document.getElementById('postQuote').value;
  const postCatID = (document.getElementById('postCatID') === null) ? null : document.getElementById('postCatID').value;

  const data = {
    'title': document.getElementById('postTitle').value,
    'text': postText,
    'quote': postQuote,
    'category_id': postCatID
  };

  axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
  
  axios.post(`?posts=keepImg&file=${fileName}`, JSON.stringify(data))
  .then(function (response) {
    // console.log(response);
    window.location.assign(`index`);

  })
  .catch(function (error) {
    // console.log(error);
    alert("Error during update! You will be redirected to the previous page."); 
    window.history.back();
  })
  .then(function () {
    // always executed
  });
}
