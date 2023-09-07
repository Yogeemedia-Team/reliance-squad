import BoxShadowComponent from './boxshadow-component.js';

export const BoxShadowControl = wp.customize.TheBaseControl.extend( {
	renderContent: function renderContent() {
		let control = this;
		ReactDOM.render(
				<BoxShadowComponent control={control} customizer={ wp.customize }/>,
				control.container[0]
		);
	}
} );
