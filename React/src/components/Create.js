import React, { Component } from 'react';
import { connect } from 'react-redux';
import { browserHistory } from 'react-router';
import { addCity } from '../serverCalls/weatherActions'


class Create extends Component {
    constructor(props) {
        super(props);
        this.state = {
            cityName: '',
            userId: '',
            userName: ''
        }
    }

    componentDidMount() {
        const userData = this.saveUserData();
        this.setState({
            userId: JSON.parse(userData).id,
            userName: JSON.parse(userData).userName
        })
    }
    saveUserData() {
        if (this.props.id != null && this.props.userName != null)
            localStorage.setItem("userData", JSON.stringify({ id: this.props.id, userName: this.props.userName }));
        return localStorage.getItem("userData");
    }

    handleCityNameChange(e) {
        this.setState({
            cityName: e.target.value
        });
    }

    handleButtonClicked(e) {
        addCity(this.state.cityName, this.state.userId, this.state.userName)
            .then(resp => console.log(resp))
            .catch(error => error.response);
    }

    render() {

        return (
            <div className="form-inline">
                <h2>Add City</h2>
                <div className="form-group">
                    <input
                        value={this.state.cityName}
                        className="form-control" type="text" placeholder="City" onChange={this.handleCityNameChange.bind(this)} />
                    <button
                        className="btn btn-primary" type="button" onClick={this.handleButtonClicked.bind(this)}> Add City </button>
                </div>
            </div>
        );
    }
}

function mapStateToProps(state) {

    return state;
}

export default connect(mapStateToProps, null)(Create);
