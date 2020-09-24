const theme = {
  TInput: {
    classes: 'bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full leading-normal dark:bg-gray-900 dark:text-gray-400 dark:border-gray-600',
    variants: {
      error: 'text-red-600 bg-red-100 focus:outline-none focus:shadow-outline border border-red-300 rounded py-2 px-4 block w-full leading-normal placeholder-red-300',
      success: 'text-green-600 bg-green-100 focus:outline-none focus:shadow-outline border border-green-300 rounded py-2 px-4 block w-full leading-normal placeholder-green-300',
      fun: 'bg-orange-100 block border-2 border-orange-300 focus:border-orange-500 focus:outline-none leading-normal px-4 py-3 rounded-full shadow-inner w-full placeholder-orange-300'
    }
  },
  TTextarea: {
    fixedClasses: "form-textarea",
    classes: "",
    variants: {
      danger: "border-red-300 bg-red-100",
      success: "border-green-300 bg-green-100",
    },
  },
  TSelect: {
    fixedClasses: 'form-select',
    classes: 'dark:border-gray-600 dark:bg-gray-900',
    variants: {
      danger: 'border-red-300 bg-red-100',
      success: 'border-green-300 bg-green-100'
    }
  },
  TRadio: {
    fixedClasses: "form-radio transition duration-150 ease-in-out",
    classes: "",
    variants: {
      error: "text-red-500 border-red-500 bg-red-100",
      success: "text-green-500 border-green-500 bg-green-100",
    },
  },
  TCheckbox: {
    fixedClasses: "form-checkbox transition duration-150 ease-in-out",
    classes: "",
    variants: {
      error: "text-red-500 border-red-500 bg-red-100",
      success: "text-green-500 border-green-500 bg-green-100",
    },
  },
  TButton: {
    fixedClasses:
      "focus:outline-none focus:shadow-outline items-center transition ease-in-out duration-150 ",
    classes:
      "dark:hover:bg-gray-600 hover:bg-gray-200 focus:border-gray-200 active:bg-gray-200 text-sm font-medium border border-transparent px-3 py-2 rounded-md bg-white border border-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-500",
    variants: {
      primary:
        "text-white bg-blue-600 hover:bg-blue-500 focus:border-blue-700 active:bg-blue-700 text-sm font-medium border border-transparent px-3 py-2 rounded-md",
      secondary:
        "text-gray-800 bg-white hover:text-gray-600 text-sm font-medium border px-3 py-2 rounded-md",
      error:
        "text-white bg-red-600 hover:bg-red-500 focus:border-red-700  active:bg-red-700 text-sm font-medium border border-transparent px-3 py-2 rounded-md",
      success:
        "text-white bg-green-600 hover:bg-green-500 focus:border-green-700 active:bg-green-700 text-sm font-medium border border-transparent px-3 py-2 rounded-md",
      link:
        "text-blue-500 underline hover:bg-blue-100 text-sm font-medium border border-transparent px-3 py-2 rounded-md",
    },
  },
  TInputGroup: {
    fixedClasses: {
      wrapper: "mb-4",
      label: "block uppercase tracking-wide text-xs font-bold mb-1",
      body: "",
      feedback: "text-sm",
      description: "text-sm",
    },
    classes: {
      wrapper: "",
      label: "",
      body: "",
      feedback: "text-gray-500",
      description: "text-gray-500",
    },
    variants: {
      danger: {
        label: "text-red-500",
        feedback: "text-red-500",
      },
      success: {
        label: "text-green-500",
        feedback: "text-green-500",
      },
    },
  },
  TRadioGroup: {
    classes: {
      groupWrapper: 'flex flex-col',
      label: 'ml-2 text-gray-700 uppercase text-sm',
      input: 'form-radio'
    },
    variants: {
      poll: {
        groupWrapper: 'flex flex-col',
        label: 'ml-2 uppercase text-sm',
        input: 'form-radio my-1'
      },
      danger: {
        groupWrapper: 'flex flex-col',
        label: 'ml-2 text-red-500 uppercase text-sm',
        input: 'form-radio text-red-500 border-red-500'
      },
      buttons: {
        groupWrapper: '',
        label: '',
        labelChecked: '',
        wrapper: 'dark:bg-gray-700 dark:text-gray-400  dark:hover:text-gray-100 mx-1 bg-white border border-gray-300 flex items-center px-4 py-2 rounded shadow-sm cursor-pointer focus:shadow-outline text-sm text-gray-700 hover:text-gray-500 leading-5 uppercase my-2',
        wrapperChecked: 'mx-1 bg-gray-100 border border-gray-300 flex items-center px-4 py-2 rounded shadow-inner cursor-pointer focus:shadow-outline text-sm text-gray-700 hover:text-gray-500 leading-5 uppercase my-2',
        inputWrapper: '',
        inputWrapperChecked: '',
        input: 'absolute invisible'
      }
    }
  },
  TRichSelect: {
    fixedClasses: {
      wrapper: "relative",
      buttonWrapper: "inline-block relative w-full",
      selectButton: "w-full flex text-left justify-between items-center",
      selectButtonLabel: "block truncate",
      selectButtonPlaceholder: "block truncate",
      selectButtonIcon: "fill-current flex-shrink-0 ml-1 h-4 w-4",
      selectButtonClearButton:
        "flex flex-shrink-0 items-center justify-center absolute right-0 top-0 m-2 h-6 w-6",
      selectButtonClearIcon: "fill-current h-3 w-3",
      dropdown: "absolute w-full z-10",
      dropdownFeedback: "",
      loadingMoreResults: "",
      optionsList: "overflow-auto",
      searchWrapper: "inline-block w-full",
      searchBox: "inline-block w-full",
      optgroup: "",
      option: "",
      highlightedOption: "",
      selectedOption: "",
      selectedHighlightedOption: "",
      optionContent: "",
      optionLabel: "truncate block",
      selectedIcon: "fill-current h-4 w-4",
      enterClass: "",
      enterActiveClass: "",
      enterToClass: "",
      leaveClass: "",
      leaveActiveClass: "",
      leaveToClass: "",
    },
    classes: {
      wrapper: "",
      buttonWrapper: "",
      selectButton:
        "bg-white border rounded p-2 focus:outline-none focus:shadow-outline",
      selectButtonLabel: "",
      selectButtonPlaceholder: "text-gray-500",
      selectButtonIcon: "",
      selectButtonClearButton: "hover:bg-gray-200 text-gray-500 rounded",
      selectButtonClearIcon: "",
      dropdown: "rounded bg-white shadow",
      dropdownFeedback: "text-sm text-gray-500",
      loadingMoreResults: "text-sm text-gray-500",
      optionsList: "",
      searchWrapper: "bg-white p-2",
      searchBox:
        "p-2 bg-gray-200 text-sm rounded border focus:outline-none focus:shadow-outline",
      optgroup: "text-gray-500 uppercase text-xs py-1 px-2 font-semibold",
      option: "",
      highlightedOption: "bg-gray-300",
      selectedOption: "font-semibold bg-gray-100",
      selectedHighlightedOption: "bg-gray-300 font-semibold",
      optionContent: "flex justify-between items-center p-2 cursor-pointer",
      optionLabel: "truncate block",
      selectedIcon: "",
      enterClass: "",
      enterActiveClass: "opacity-0 transition ease-out duration-100",
      enterToClass: "opacity-100",
      leaveClass: "transition ease-in opacity-100",
      leaveActiveClass: "",
      leaveToClass: "opacity-0 duration-75",
    },
    variants: {
      danger: {
        selectButton:
          "border-red-500 text-red-500 bg-red-100 border rounded p-2 focus:outline-none focus:shadow-outline",
        selectButtonPlaceholder: "text-red-400",
        selectButtonClearButton: "hover:bg-red-200 text-red-500 rounded",
      },
      success: {
        selectButton:
          "border-green-500 text-green-500 bg-green-100 border rounded p-2 focus:outline-none focus:shadow-outline",
        selectButtonPlaceholder: "text-green-400",
        selectButtonClearButton: "hover:bg-green-200 text-green-500 rounded",
      },
    },
  },
  TTag: {
    fixedClasses: "",
    classes: "",
    variants: {
      title: "text-2xl leading-8 font-extrabold text-gray-900 tracking-tight",
      subtitle: "text-lg leading-6 font-medium text-gray-900",
      error: "text-red-500",
      badge:
        "inline-flex items-center px-3 rounded-full text-xs font-medium leading-4 bg-gray-100 text-gray-800",
      avatar:
        "inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-500 overflow-hidden leading-none text-center",
    },
  },
  TAlert: {
    fixedClasses: {
      wrapper: "rounded p-4 flex text-sm border-l-4",
      body: "flex-grow",
      close: "ml-4 rounded",
      closeIcon: "h-5 w-5 fill-current",
    },
    classes: {
      wrapper: "bg-blue-100 border-blue-500",
      body: "text-blue-700",
      close: "text-blue-700 hover:text-blue-500 hover:bg-blue-200",
      closeIcon: "h-5 w-5 fill-current",
    },
    variants: {
      danger: {
        wrapper: "bg-red-100 border-red-500 dark:bg-red-300 dark:border-red-600",
        body: "text-red-700",
        close: "text-red-700 hover:text-red-500 hover:bg-red-200",
      },
      success: {
        wrapper: "bg-green-100 border-green-500",
        body: "text-green-700",
        close: "text-green-700  hover:text-green-500 hover:bg-green-200",
      },
    },
  },
  TCard: {
    fixedClasses: {
      wrapper: "rounded mx-auto shadow dark:bg-gray-900 dark:text-gray-400 border dark:border-gray-500",
      body: "p-4",
      header: "p-4 border-b dark:border-gray-400",
      footer: "p-4 border-t dark:border-gray-400",
    },
    classes: {
      wrapper: "bg-white",
      body: "",
      header: "",
      footer: "",
    },
    variants: {
      danger: {
        wrapper: "bg-red-100 text-red-700",
        header: "border-red-200 text-red-700",
        footer: "border-red-200 bg-red-100 text-red-700",
      },
    },
  },
  TModal: {
    fixedClasses: {
      overlay: "z-40 overflow-auto left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-opacity-50",
      wrapper: "z-50 relative mx-auto my-0 max-w-lg mt-12",
      modal: "bg-white shadow overflow-hidden relative rounded dark:bg-gray-700 dark:text-gray-400",
      body: "p-4",
      header: "p-4  text-sm font-semibold uppercase text-gray-700 dark:text-gray-400",
      footer: "p-4 text-sm font-semibold uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400",
      close: "absolute right-0 top-0 m-3 text-gray-700 hover:text-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:text-gray-200",
      closeIcon: "h-5 w-5 fill-current",
    },
    classes: {
      overlay: "bg-black ",
      wrapper: "",
      modal: "",
      body: "p-4",
      header: "text-gray-700 border-b dark:border-gray-400",
      footer: "border-t dakr:border-gray-400",
      close: "text-gray-700 hover:text-gray-600 ",
      closeIcon: "",
    },
    variants: {
      danger: {
        overlay: "bg-red-500",
        header: "border-red-100 text-red-700 border-b",
        footer: "border-red-100 bg-red-100 border-t  ",
        close: "text-red-700 hover:text-red-600",
      },
      clean: {
        modal: "rounded shadow-lg ",
        footer: "bg-gray-100 ",
        body: "p-4 text-sm text-gray-700",
        close:
          "bg-blue-100 p-1 flex items-center justify-center leading-normal rounded-full text-blue-80 hover:bg-blue-200",
      },
    },
  },
  TTable: {
    classes: {
      table: "shadow min-w-full divide-y divide-gray-200 dark:divide-gray-400 border dark:border-gray-400",
      tbody: "bg-white divide-y divide-gray-200 dark:divide-gray-400 dark:bg-gray-700 dark:text-gray-300",
      td: "px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-700 dark:text-gray-400",
      theadTh:
        "px-6 py-3 border-b border-gray-200 dark:border-gray-400 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider dark:bg-gray-700 dark:text-gray-300",
    },
    variants: {
      thin: {
        td: "p-1 whitespace-no-wrap text-sm leading-4 text-gray-700",
        theadTh:
          "p-1 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider",
      },
    },
  },
  TPagination: {
    classes: {
      wrapper: "select-none table border-collapse text-center bg-white mx-auto mt-2 dark:text-gray-400 dark:bg-gray-900",
      element: "w-8 h-8 border table-cell dark:border-gray-400",
      disabledElement: "w-8 h-8 border dark:border-gray-500 table-cell",
      ellipsisElement: "w-8 h-8 border dark:border-gray-500 hidden md:table-cell",
      activeButton: "bg-gray-300 dark:bg-gray-800 w-full h-full",
      disabledButton: "opacity-25 dark:border-gray-600 w-full h-full cursor-not-allowed",
      button: "hover:bg-gray-200 dark:hover:bg-gray-800 w-full h-full",
      ellipsis: "",
    },
    variants: {
      rounded: {
        wrapper: "flex",
        element: "w-8 h-8 mx-1",
        disabledElement: "w-8 h-8 mx-1",
        ellipsisElement: "w-8 h-8 mx-1",
        activeButton: "bg-blue-500 w-full h-full text-white rounded-full ",
        disabledButton:
          "opacity-25 w-full h-full cursor-not-allowed rounded-full",
        button: "hover:bg-blue-100 w-full h-full text-blue-500 rounded-full ",
        ellipsis: "text-gray-500",
      },
    },
  },
  TDropdown: {
    classes: {
      button: "px-4 py-2 flex items-center border rounded hover:text-gray-700",
      wrapper: "inline-flex flex-col",
      dropdownWrapper: "relative z-10",
      dropdown:
        "origin-top-right absolute right-0 w-56 rounded-md shadow-lg bg-white",
      enterClass: "",
      enterActiveClass:
        "transition ease-out duration-100 transform opacity-0 scale-95",
      enterToClass: "transform opacity-100 scale-100",
      leaveClass: "transition ease-in transform opacity-100 scale-100",
      leaveActiveClass: "",
      leaveToClass: "transform opacity-0 scale-95 duration-75",
    },
    variants: {
      danger: {
        button:
          "px-4 py-2 flex items-center border rounded bg-red-100 border-red-600 text-red-500 hover:text-red-400",
        dropdown:
          "origin-top-right absolute right-0 w-56 rounded-md shadow bg-red-100",
      },
    },
  },
};
export default theme;
