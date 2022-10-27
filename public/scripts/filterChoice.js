function filterChoice()
{
    const radio = document.getElementsByName('choice');

    for (let i = 0; i < radio.length; i++)
    {
        if(radio[i].checked)
        {
            console.log(radio[i].value);
            if(radio[i].value === 'unactivate')
            {
                let element = document.querySelectorAll('#element');
                console.log(element);
                element.classList.add("d-none");
            }
            
        }
    }
}