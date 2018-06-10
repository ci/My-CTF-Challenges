let bookTemplate = `
<div class="col-lg-4 col-sm-6 text-center mb-4">
  <h3>%NAME%</h3>
  <p>%MESSAGE%</p>
</div>
`;

let bookMessages = [
    'A great book indeed!',
    'Best content you can get out there.',
    'Best-seller & #1 10 times in a row.',
    'Featured and recommended by us.',
];

$.ajax({
    url: 'booklist.php',
    dataType: 'json',
    type: 'GET',
    headers: {'X-Dir': '.'},
    success: (books) => {
        let container = $('#books');
        books.forEach(book => {
            // let message = bookMessages[Math.floor(Math.random() * bookMessages.length)];
            $.getJSON('booklist.php?f=' + book.name, message => {
                container.append(bookTemplate.replace(/%NAME%/g, book.name).replace(/%MESSAGE%/g, message));
            });
        })
    },
});
