// fetch list peminjaman
fetch('peminjaman.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        user_id: 1,
        book_id: 101,
        loan_date: "2024-12-01",
        return_date: "2024-12-15"
    })
})
.then(response => response.json())
.then(data => {
    console.log('Success:', data);
})
.catch((error) => {
    console.error('Error:', error);
});

