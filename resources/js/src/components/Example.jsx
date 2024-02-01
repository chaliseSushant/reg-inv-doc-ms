import React from 'react';
import ReactDOM from 'react-dom';

function Example() {
    return (
        <div>
            This is react app
        </div>
    );
}

export default Example;

if (document.getElementById('root')) {
    ReactDOM.render(<Example />, document.getElementById('root'));
}
