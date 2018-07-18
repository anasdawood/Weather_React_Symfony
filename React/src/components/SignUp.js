import React, { Component } from 'react';
import { registerUser } from '../serverCalls/userActions';

class SignUp extends Component {
    constructor(props) {
        super(props);
        this.state = {
            email: '',
            password: ''
        }
    }

    handleEmailChange(e) {
        this.setState({
            email: e.target.value
        });
    }

    handlePasswordChange(e) {

        this.setState({
            password: e.target.value
        });

    }

    handleButtonClicked(e) {

        e.preventDefault();
        let userData = {
            userName: this.state.email,
            userPassword: this.state.password
        };
        registerUser(userData).
            then((res) => {
                console.log(res);
            }).catch((err) => err);


    }

    render() {
        return (
            <div className="form-inline">
                <h2>Sign Up</h2>
                <div className="form-group">
                    <input
                        value={this.state.email}
                        className="form-control" type="text" placeholder="E-mail" onChange={this.handleEmailChange.bind(this)} />
                    <input
                        value={this.state.password}
                        className="form-control" type="password" placeholder="Password" onChange={this.handlePasswordChange.bind(this)} />
                    <button
                        className="btn btn-primary" type="button" onClick={this.handleButtonClicked.bind(this)}> Sign Up </button>
                </div>
            </div>
        );
    }
}

export default SignUp;
